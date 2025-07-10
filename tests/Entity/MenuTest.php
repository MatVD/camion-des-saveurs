<?php

namespace App\Tests\Entity;

use App\Entity\Menu;
use App\Entity\OrderItem;
use PHPUnit\Framework\TestCase;

class MenuTest extends TestCase
{
    private Menu $menu;

    protected function setUp(): void
    {
        $this->menu = new Menu();
    }

    public function testGetId(): void
    {
        $this->assertNull($this->menu->getId());
    }

    public function testSetAndGetName(): void
    {
        $name = 'Burger Royal';
        $result = $this->menu->setName($name);
        
        $this->assertSame($this->menu, $result);
        $this->assertSame($name, $this->menu->getName());
    }

    public function testSetAndGetDescription(): void
    {
        $description = 'Délicieux burger avec fromage et bacon';
        $result = $this->menu->setDescription($description);
        
        $this->assertSame($this->menu, $result);
        $this->assertSame($description, $this->menu->getDescription());
    }

    public function testSetAndGetDescriptionWithNull(): void
    {
        $result = $this->menu->setDescription(null);
        
        $this->assertSame($this->menu, $result);
        $this->assertNull($this->menu->getDescription());
    }

    public function testSetAndGetPrice(): void
    {
        $price = '12.50';
        $result = $this->menu->setPrice($price);
        
        $this->assertSame($this->menu, $result);
        $this->assertSame($price, $this->menu->getPrice());
    }

    public function testSetAndGetCategory(): void
    {
        $category = 'Burgers';
        $result = $this->menu->setCategory($category);
        
        $this->assertSame($this->menu, $result);
        $this->assertSame($category, $this->menu->getCategory());
    }

    public function testSetAndGetCategoryWithNull(): void
    {
        $result = $this->menu->setCategory(null);
        
        $this->assertSame($this->menu, $result);
        $this->assertNull($this->menu->getCategory());
    }

    public function testSetAndIsAvailable(): void
    {
        $result = $this->menu->setAvailable(true);
        
        $this->assertSame($this->menu, $result);
        $this->assertTrue($this->menu->isAvailable());
        
        $this->menu->setAvailable(false);
        $this->assertFalse($this->menu->isAvailable());
    }

    public function testSetAndIsAvailableWithNull(): void
    {
        $result = $this->menu->setAvailable(null);
        
        $this->assertSame($this->menu, $result);
        $this->assertNull($this->menu->isAvailable());
    }

    public function testSetAndGetImae(): void
    {
        $image = 'burger-royal.jpg';
        $result = $this->menu->setImae($image);
        
        $this->assertSame($this->menu, $result);
        $this->assertSame($image, $this->menu->getImae());
    }

    public function testSetAndGetImaeWithNull(): void
    {
        $result = $this->menu->setImae(null);
        
        $this->assertSame($this->menu, $result);
        $this->assertNull($this->menu->getImae());
    }

    public function testConstructorInitializesOrderItemsCollection(): void
    {
        $orderItems = $this->menu->getOrderItems();
        
        $this->assertInstanceOf(\Doctrine\Common\Collections\Collection::class, $orderItems);
        $this->assertCount(0, $orderItems);
    }

    public function testAddOrderItem(): void
    {
        $orderItem = $this->createMock(OrderItem::class);
        $orderItem->expects($this->once())
                  ->method('setMenuItem')
                  ->with($this->menu);
        
        $result = $this->menu->addOrderItem($orderItem);
        
        $this->assertSame($this->menu, $result);
        $this->assertCount(1, $this->menu->getOrderItems());
        $this->assertTrue($this->menu->getOrderItems()->contains($orderItem));
    }

    public function testAddOrderItemDoesNotAddDuplicate(): void
    {
        $orderItem = $this->createMock(OrderItem::class);
        $orderItem->expects($this->once())
                  ->method('setMenuItem')
                  ->with($this->menu);
        
        $this->menu->addOrderItem($orderItem);
        $this->menu->addOrderItem($orderItem); // Add same item again
        
        $this->assertCount(1, $this->menu->getOrderItems());
    }

    public function testRemoveOrderItem(): void
    {
        $orderItem = $this->createMock(OrderItem::class);
        
        // We'll track the calls manually
        $setMenuItemCalls = [];
        $orderItem->method('setMenuItem')
                  ->willReturnCallback(function ($menu) use (&$setMenuItemCalls, $orderItem) {
                      $setMenuItemCalls[] = $menu;
                      return $orderItem;
                  });
        
        $orderItem->expects($this->once())
                  ->method('getMenuItem')
                  ->willReturn($this->menu);
        
        $this->menu->addOrderItem($orderItem);
        $this->assertCount(1, $this->menu->getOrderItems());
        
        $result = $this->menu->removeOrderItem($orderItem);
        
        $this->assertSame($this->menu, $result);
        $this->assertCount(0, $this->menu->getOrderItems());
        $this->assertFalse($this->menu->getOrderItems()->contains($orderItem));
        
        // Verify setMenuItem was called twice: once with menu, once with null
        $this->assertCount(2, $setMenuItemCalls);
        $this->assertSame($this->menu, $setMenuItemCalls[0]);
        $this->assertNull($setMenuItemCalls[1]);
    }

    public function testRemoveOrderItemWhenNotOwning(): void
    {
        $orderItem = $this->createMock(OrderItem::class);
        $otherMenu = new Menu();
        
        // Track setMenuItem calls
        $setMenuItemCalls = [];
        $orderItem->method('setMenuItem')
                  ->willReturnCallback(function ($menu) use (&$setMenuItemCalls, $orderItem) {
                      $setMenuItemCalls[] = $menu;
                      return $orderItem;
                  });
        
        $orderItem->expects($this->once())
                  ->method('getMenuItem')
                  ->willReturn($otherMenu);
        
        $this->menu->addOrderItem($orderItem);
        $result = $this->menu->removeOrderItem($orderItem);
        
        $this->assertSame($this->menu, $result);
        
        // Verify setMenuItem was called only once (during add)
        $this->assertCount(1, $setMenuItemCalls);
        $this->assertSame($this->menu, $setMenuItemCalls[0]);
    }

    public function testRemoveNonExistentOrderItem(): void
    {
        $orderItem = $this->createMock(OrderItem::class);
        
        $result = $this->menu->removeOrderItem($orderItem);
        
        $this->assertSame($this->menu, $result);
        $this->assertCount(0, $this->menu->getOrderItems());
    }

    public function testFluentInterface(): void
    {
        $result = $this->menu
            ->setName('Test Menu')
            ->setDescription('Test Description')
            ->setPrice('10.00')
            ->setCategory('Test Category')
            ->setAvailable(true)
            ->setImae('test.jpg');
        
        $this->assertSame($this->menu, $result);
        $this->assertSame('Test Menu', $this->menu->getName());
        $this->assertSame('Test Description', $this->menu->getDescription());
        $this->assertSame('10.00', $this->menu->getPrice());
        $this->assertSame('Test Category', $this->menu->getCategory());
        $this->assertTrue($this->menu->isAvailable());
        $this->assertSame('test.jpg', $this->menu->getImae());
    }
}