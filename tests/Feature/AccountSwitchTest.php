<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('adds another authenticated account to the session and switches to it', function () {
    $currentAccount = User::factory()->create();
    $newAccount = User::factory()->create();

    $this->actingAs($currentAccount)
        ->post(route('account.add'), [
            'email' => $newAccount->email,
            'password' => 'admin',
        ])
        ->assertRedirect(route('dashboard'));

    $this->assertAuthenticatedAs($newAccount);
    expect(session('signed_in_account_ids'))->toBe([$currentAccount->id, $newAccount->id]);
});

it('switches only to accounts previously authenticated in this session', function () {
    $currentAccount = User::factory()->create();
    $savedAccount = User::factory()->create();
    $otherAccount = User::factory()->create();

    $this->actingAs($currentAccount)
        ->withSession(['signed_in_account_ids' => [$currentAccount->id, $savedAccount->id]])
        ->post(route('account.switch'), ['account_id' => $savedAccount->id])
        ->assertRedirect(route('dashboard'));

    $this->assertAuthenticatedAs($savedAccount);

    $this->post(route('account.switch'), ['account_id' => $otherAccount->id])
        ->assertForbidden();

    $this->assertAuthenticatedAs($savedAccount);
});

it('rejects invalid credentials without switching the active account', function () {
    $currentAccount = User::factory()->create();
    $otherAccount = User::factory()->create();

    $this->actingAs($currentAccount)
        ->withSession(['signed_in_account_ids' => [$currentAccount->id]])
        ->from(route('dashboard'))
        ->post(route('account.add'), [
            'email' => $otherAccount->email,
            'password' => 'invalid-password',
        ])
        ->assertRedirect(route('dashboard'))
        ->assertSessionHasErrors('email');

    $this->assertAuthenticatedAs($currentAccount);
    expect(session('signed_in_account_ids'))->toBe([$currentAccount->id]);
});
