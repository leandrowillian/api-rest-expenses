<?php

namespace Tests\Unit;

use App\Models\Expense;
use App\Models\User;
use App\Notifications\ExpenseCreated;
use App\Repositories\Contracts\ExpenseRepositoryInterface;
use App\Services\ExpenseService;
use Illuminate\Support\Facades\Notification;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class ExpenseServiceTest extends TestCase
{
    #[Test]
    public function it_can_create_an_expense()
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
            'amount' => 100.50,
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

        // Verifique se a despesa foi criada corretamente
        $this->assertInstanceOf(Expense::class, $expense);
        $this->assertEquals('Expense Test', $expense->description);
        $this->assertEquals(100.50, $expense->amount);

        // Check if notification was sent
        Notification::assertSentTo($user, ExpenseCreated::class);
    }
}
