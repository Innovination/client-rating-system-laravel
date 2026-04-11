<?php

namespace Tests\Feature;

use App\Models\AgencyProfile;
use App\Models\Client;
use App\Models\ClientFeedback;
use App\Models\Dispute;
use App\Models\DisputeCategory;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PhaseOneMvpTest extends TestCase
{
    use RefreshDatabase;

    public function test_unverified_agency_cannot_submit_dispute_or_feedback(): void
    {
        $agency = User::factory()->unverified()->create([
            'role' => User::ROLE_AGENCY,
            'status' => User::STATUS_ACTIVE,
        ]);
        $client = Client::factory()->create();
        $category = DisputeCategory::factory()->create();

        $this->actingAs($agency);

        $this->post(route('agency.disputes.store'), [
            'client_id' => $client->id,
            'dispute_category_id' => $category->id,
            'project_type' => 'Web Development',
            'dispute_type' => 'non_payment',
            'issue_description' => 'Payment was not released after final delivery.',
        ])->assertRedirect(route('verification.notice'));

        $this->post(route('agency.feedback.store'), [
            'client_id' => $client->id,
            'rating' => 1,
            'feedback_text' => 'Communication broke down after milestone two.',
        ])->assertRedirect(route('verification.notice'));
    }

    public function test_agency_can_update_its_profile(): void
    {
        $agency = User::factory()->create([
            'role' => User::ROLE_AGENCY,
            'status' => User::STATUS_ACTIVE,
        ]);

        $profile = AgencyProfile::factory()->create(['user_id' => $agency->id]);

        $this->actingAs($agency)
            ->put(route('agency.profile.update'), [
                'company_name' => 'Updated Co',
                'contact_person' => 'Updated Contact',
                'phone' => '9999911111',
                'email' => 'updated@example.com',
                'website' => 'https://updated.example.com',
                'address' => 'Street 123',
                'city' => 'Delhi',
                'country' => 'India',
                'company_info' => 'Updated profile details.',
            ])
            ->assertRedirect(route('agency.profile.show'));

        $this->assertDatabaseHas('agency_profiles', [
            'id' => $profile->id,
            'company_name' => 'Updated Co',
            'contact_person' => 'Updated Contact',
            'phone' => '9999911111',
            'city' => 'Delhi',
        ]);

        $this->assertDatabaseHas('users', [
            'id' => $agency->id,
            'email' => 'updated@example.com',
            'mobile' => '9999911111',
        ]);
    }

    public function test_feedback_submission_updates_existing_entry_for_same_agency_and_client(): void
    {
        $agency = User::factory()->create([
            'role' => User::ROLE_AGENCY,
            'status' => User::STATUS_ACTIVE,
        ]);
        $client = Client::factory()->create();

        $this->actingAs($agency);

        $this->post(route('agency.feedback.store'), [
            'client_id' => $client->id,
            'rating' => 2,
            'feedback_text' => 'Initial review',
        ])->assertRedirect(route('agency.clients.show', $client));

        $this->post(route('agency.feedback.store'), [
            'client_id' => $client->id,
            'rating' => 5,
            'feedback_text' => 'Updated review after resolution',
        ])->assertRedirect(route('agency.clients.show', $client));

        $this->assertDatabaseCount('client_feedback', 1);
        $this->assertDatabaseHas('client_feedback', [
            'client_id' => $client->id,
            'agency_user_id' => $agency->id,
            'rating' => 5,
            'feedback_text' => 'Updated review after resolution',
        ]);
    }

    public function test_public_client_profile_shows_only_visible_moderated_data(): void
    {
        $agency = User::factory()->create();
        AgencyProfile::factory()->create([
            'user_id' => $agency->id,
            'company_name' => 'Trusted Agency LLP',
            'phone' => '8888888888',
        ]);

        $client = Client::factory()->create();

        Dispute::factory()->create([
            'client_id' => $client->id,
            'agency_user_id' => $agency->id,
            'issue_description' => 'Visible dispute body',
            'status' => Dispute::STATUS_VISIBLE,
        ]);

        Dispute::factory()->create([
            'client_id' => $client->id,
            'agency_user_id' => $agency->id,
            'issue_description' => 'Hidden dispute body',
            'status' => Dispute::STATUS_HIDDEN,
        ]);

        ClientFeedback::factory()->create([
            'client_id' => $client->id,
            'agency_user_id' => $agency->id,
            'feedback_text' => 'Visible feedback body',
            'status' => ClientFeedback::STATUS_VISIBLE,
        ]);

        ClientFeedback::factory()->create([
            'client_id' => $client->id,
            'agency_user_id' => User::factory()->create()->id,
            'feedback_text' => 'Hidden feedback body',
            'status' => ClientFeedback::STATUS_HIDDEN,
        ]);

        $response = $this->get(route('clients.show', $client));

        $response->assertOk();
        $response->assertSee('Visible dispute body');
        $response->assertDontSee('Hidden dispute body');
        $response->assertSee('Visible feedback body');
        $response->assertDontSee('Hidden feedback body');
    }

    public function test_admin_can_moderate_disputes_and_feedback_and_logs_are_written(): void
    {
        $admin = User::factory()->admin()->create();
        $agency = User::factory()->create();
        $client = Client::factory()->create();

        $dispute = Dispute::factory()->create([
            'client_id' => $client->id,
            'agency_user_id' => $agency->id,
            'status' => Dispute::STATUS_VISIBLE,
        ]);

        $feedback = ClientFeedback::factory()->create([
            'client_id' => $client->id,
            'agency_user_id' => $agency->id,
            'status' => ClientFeedback::STATUS_VISIBLE,
        ]);

        $this->actingAs($admin)
            ->patch(route('admin.moderation.disputes.update', $dispute), [
                'status' => Dispute::STATUS_HIDDEN,
            ])->assertRedirect();

        $this->actingAs($admin)
            ->patch(route('admin.moderation.feedback.update', $feedback), [
                'status' => ClientFeedback::STATUS_HIDDEN,
            ])->assertRedirect();

        $this->assertDatabaseHas('disputes', [
            'id' => $dispute->id,
            'status' => Dispute::STATUS_HIDDEN,
            'moderated_by' => $admin->id,
        ]);

        $this->assertDatabaseHas('client_feedback', [
            'id' => $feedback->id,
            'status' => ClientFeedback::STATUS_HIDDEN,
            'moderated_by' => $admin->id,
        ]);

        $this->assertDatabaseHas('admin_action_logs', [
            'admin_user_id' => $admin->id,
            'action_type' => 'hide_dispute',
            'target_type' => Dispute::class,
            'target_id' => $dispute->id,
        ]);

        $this->assertDatabaseHas('admin_action_logs', [
            'admin_user_id' => $admin->id,
            'action_type' => 'hide_feedback',
            'target_type' => ClientFeedback::class,
            'target_id' => $feedback->id,
        ]);
    }

    public function test_non_admin_user_cannot_access_admin_moderation_queue(): void
    {
        $agency = User::factory()->create([
            'role' => User::ROLE_AGENCY,
            'status' => User::STATUS_ACTIVE,
        ]);

        $this->actingAs($agency)
            ->get(route('admin.moderation.index'))
            ->assertForbidden();
    }

    public function test_suspended_user_cannot_login(): void
    {
        User::factory()->suspended()->create([
            'email' => 'suspended@example.com',
            'password' => bcrypt('password'),
        ]);

        $this->post(route('login'), [
            'email' => 'suspended@example.com',
            'password' => 'password',
        ])->assertRedirect(route('login'))
            ->assertSessionHasErrors('email');

        $this->assertGuest();
    }
}

