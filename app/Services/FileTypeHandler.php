<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class FileTypeHandler
{
    protected $file;
    protected $type;

    public function __construct(UploadedFile $file)
    {
        $this->file = $file;
        $this->type = $this->detectFileType($file->getMimeType());
    }

    public function process()
    {
        switch ($this->type) {
            case 'image':
                return $this->processImage();
            case 'video':
                return $this->processVideo();
            case 'audio':
                return $this->processAudio();
            case 'document':
                return $this->processDocument();
            default:
                throw new \Exception('Tipo de archivo no soportado');
        }
    }

    protected function detectFileType($mimeType)
    {
        if (str_starts_with($mimeType, 'image/')) {
            return 'image';
        } elseif (str_starts_with($mimeType, 'video/')) {
            return 'video';
        } elseif (str_starts_with($mimeType, 'audio/')) {
            return 'audio';
        } else {
            return 'document';
        }
    }

    protected function processImage()
    {
        $path = 'multimedia/images/' . date('Y/m');
        $fileName = uniqid() . '.' . $this->file->getClientOriginalExtension();
        $filePath = $path . '/' . $fileName;

        // Guardar imagen
        $this->file->storeAs('public/' . $path, $fileName);

        return [
            'path' => $filePath,
            'type' => 'image',
            'metadata' => [
                'mime' => $this->file->getMimeType(),
                'size' => $this->file->getSize(),
                'extension' => $this->file->getClientOriginalExtension()
            ]
        ];
    }

    protected function processVideo()
    {
        $path = 'multimedia/videos/' . date('Y/m');
        $fileName = uniqid() . '.' . $this->file->getClientOriginalExtension();
        $filePath = $path . '/' . $fileName;

        // Guardar video
        $this->file->storeAs('public/' . $path, $fileName);

        return [
            'path' => $filePath,
            'type' => 'video',
            'metadata' => [
                'mime' => $this->file->getMimeType(),
                'size' => $this->file->getSize(),
                'extension' => $this->file->getClientOriginalExtension()
            ]
        ];
    }

    protected function processAudio()
    {
        $path = 'multimedia/audio/' . date('Y/m');
        $fileName = uniqid() . '.' . $this->file->getClientOriginalExtension();
        $filePath = $path . '/' . $fileName;

        // Guardar audio
        $this->file->storeAs('public/' . $path, $fileName);

        return [
            'path' => $filePath,
            'type' => 'audio',
            'metadata' => [
                'mime' => $this->file->getMimeType(),
                'size' => $this->file->getSize(),
                'extension' => $this->file->getClientOriginalExtension()
            ]
        ];
    }

    protected function processDocument()
    {
        $path = 'multimedia/documents/' . date('Y/m');
        $fileName = uniqid() . '.' . $this->file->getClientOriginalExtension();
        $filePath = $path . '/' . $fileName;

        // Guardar documento
        $this->file->storeAs('public/' . $path, $fileName);

        return [
            'path' => $filePath,
            'type' => 'document',
            'metadata' => [
                'mime' => $this->file->getMimeType(),
                'size' => $this->file->getSize(),
                'extension' => $this->file->getClientOriginalExtension()
            ]
        ];
    }
} 