<?php


use PHPUnit\Framework\TestCase;
use Psr\Http\Message\UploadedFileInterface;
use Legacy\Legacy\File\Upload;

class UploadTest extends TestCase
{
    private Upload $upload;

    protected function setUp(): void
    {
        $this->upload = new Upload('tests');
    }

    public function tearDown(): void
    {
       if(file_exists('tests/logo.jpg'))
       {
           unlink('tests/logo.jpg');
       }
    }

    public function testUpload()
    {
        $uploadFile = $this->getMockBuilder(UploadedFileInterface::class)
            ->getMock();

        $uploadFile->expects($this->any())
            ->method('getClientFilename')
            ->willReturn('logo.jpg');

        $uploadFile->expects($this->once())
            ->method('moveTo')
            ->with($this->equalTo('tests/logo.jpg'));

        $this->assertEquals('logo.jpg',$this->upload->upload($uploadFile));
    }

    public function testUploadExistingFile()
    {
        $uploadFile = $this->getMockBuilder(UploadedFileInterface::class)
            ->getMock();

        $uploadFile->expects($this->any())
            ->method('getClientFilename')
            ->willReturn('logo.jpg');

        touch('tests/logo.jpg');

        $uploadFile->expects($this->once())
            ->method('moveTo')
            ->with($this->equalTo('tests/logo_copy.jpg'));

        $this->assertEquals('logo_copy.jpg',$this->upload->upload($uploadFile));
    }
}