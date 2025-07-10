<?php

namespace App\Tests\Entity;

use App\Entity\Order;
use App\Entity\OrderItem;
use PHPUnit\Framework\TestCase;

class OrderTest extends TestCase
{
    private Order $order;

    protected function setUp(): void
    {
        $this->order = new Order();
    }
    
    public function testGetId(): void
    {
        $this->assertNull($this->order->getId());
    }

    public function testSetAndGetCustomer(): void
    {
        $customer = $this->createMock('App\Entity\User');
        $result = $this->order->setCustomer($customer);

        $this->assertSame($this->order, $result);
        $this->assertSame($customer, $this->order->getCustomer());
    }
}