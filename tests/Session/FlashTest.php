<?php


namespace Session;


use PHPUnit\Framework\TestCase;
use Zgeniuscoders\Zgeniuscoders\Session\ArraySession;
use Zgeniuscoders\Zgeniuscoders\Session\Flash;

class FlashTest extends TestCase
{
    /**
     * @var ArraySession
     */
    private ArraySession $session;

    /**
     * @var Flash
     */
    private Flash $flash;

    protected function setUp(): void
    {
        $this->session = new ArraySession();
        $this->flash = new Flash($this->session);
    }

    public function testDeleteSessionAfterGettingIt()
    {
        $this->flash->success('connected');
        $this->assertEquals('connected',$this->flash->get('connected'));
        $this->assertNull($this->flash->get('connected'));
        $this->assertEquals('connected',$this->flash->get('connected'));
        $this->assertEquals('connected',$this->flash->get('connected'));
    }
}