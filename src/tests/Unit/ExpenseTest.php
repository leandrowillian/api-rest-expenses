<?php

namespace Tests\Unit;

use App\Models\Expense;
use App\Models\User;
use App\Policies\ExpensePolicy;
use App\Repositories\Contracts\ExpenseRepositoryInterface;
use App\Services\ExpenseService;
use Illuminate\Support\Facades\Notification;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class ExpenseTest extends TestCase
{
    #[Test]
    public function it_belongs_to_a_user()
    {
        // Fake notifications
        Notification::fake();

        // Repository mock
        $mockRepo = $this->createMock(ExpenseRepositoryInterface::class);

        // Create an User
        $user = User::factory()->create();

        // Expense data
        $expenseData = [
            'description' => 'Expense Test',
            'amount' => 1002.50,
            'date' => now()->format('Y-m-d'),
            'user_id' => $user->id
        ];

        // Mock create method
        $mockRepo
            ->expects($this->once())
            ->method('create')
            ->with($expenseData)
            ->willReturn(new Expense($expenseData));
        
        // Instantiate the service
        $service = new ExpenseService($mockRepo);

        // Call create from the service
        $expense = $service->create($expenseData);

        $this->assertInstanceOf(User::class, $expense->user);
    }

    #[Test]
    public function a_user_can_only_update_their_own_expense()
    {
        // Fake notifications
        Notification::fake();
        
        $user = User::factory()->create();
        $otherUser = User::factory()->create();
        
        // Repository mock
        $mockRepo = $this->createMock(ExpenseRepositoryInterface::class);

        // Expense data
        $expenseData = [
            'description' => 'Expense Test',
            'amount' => 1002.50,
            'date' => now()->format('Y-m-d'),
            'user_id' => $user->id
        ];

        // Mock create method
        $mockRepo
            ->expects($this->once())
            ->method('create')
            ->with($expenseData)
            ->willReturn(new Expense($expenseData));
        
        // Instantiate the service
        $service = new ExpenseService($mockRepo);

        // Call create from the service
        $expense = $service->create($expenseData);


        $policy = new ExpensePolicy();

        $this->assertTrue($policy->update($user, $expense));
        $this->assertFalse($policy->update($otherUser, $expense));
    }
}
