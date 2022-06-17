<?php


namespace Legacy\Legacy\File;

use Psr\Http\Message\UploadedFileInterface;

class Upload
{

    protected $formats;


    public function __construct(protected ?string $path = 'public/storage')
    {
    }


    /**
     * permet d'uploader un fichier
     * @param UploadedFileInterface $file
     * @param string|null $oldFile
     * @return string
     */
    public function upload(UploadedFileInterface $file, ?string $oldFile = null): string
    {
        $this->delete($oldFile);
        $target = $this->addSuffix($this->path . DIRECTORY_SEPARATOR .$file->getClientFilename());
        $dirname = pathinfo($target, PATHINFO_DIRNAME);

        if (!file_exists($dirname)) {
            mkdir($dirname, 777, true);
        }

        $file->moveTo($target);
        return pathinfo($target)['basename'];
    }

    private function addSuffix(string $targetPath): string
    {
        if (file_exists($targetPath)) {
            $info = pathinfo($targetPath);
            $targetPath = $info['dirname'] .
                DIRECTORY_SEPARATOR .
                $info['filename'] .
                '_copy' .
                '.' . $info["extension"];

            return $this->addSuffix($targetPath);
        }
        return $targetPath;
    }

    /**
     * permet de supprimmer un fichier s'il existe deja
     * @param string|null $old
     */
    private function delete(?string $old)
    {
        if ($old) {
            $old = $this->path .DIRECTORY_SEPARATOR .$old;
            if (file_exists($old)) {
                unlink($old);
            }
        }
    }

    /**
     * @param string|null $path
     */
    public function setPath(?string $path): void
    {
        $this->path = $path;
    }
}
