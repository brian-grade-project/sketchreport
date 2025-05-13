<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use FFMpeg\FFMpeg;
use FFMpeg\Coordinate\TimeCode;

class FileTypeHandler
{
    protected $file;
    protected $type;
    protected $path;
    protected $imageManager;

    public function __construct(UploadedFile $file)
    {
        $this->file = $file;
        $this->type = $this->detectFileType($file->getMimeType());
        $this->imageManager = new ImageManager(new Driver());
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
        // Crear directorio si no existe
        $path = 'multimedia/images/' . date('Y/m');
        if (!file_exists(storage_path('app/public/' . $path))) {
            mkdir(storage_path('app/public/' . $path), 0755, true);
        }

        // Procesar imagen
        $image = $this->imageManager->read($this->file);
        
        // Generar thumbnail
        $thumbnail = $image->resize(300, 300, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });

        $fileName = uniqid() . '.' . $this->file->getClientOriginalExtension();
        $thumbnailPath = $path . '/thumb_' . $fileName;
        $originalPath = $path . '/' . $fileName;

        // Guardar original y thumbnail
        $image->save(storage_path('app/public/' . $originalPath));
        $thumbnail->save(storage_path('app/public/' . $thumbnailPath));

        return [
            'path' => $originalPath,
            'thumbnail' => $thumbnailPath,
            'type' => 'image',
            'metadata' => [
                'width' => $image->width(),
                'height' => $image->height(),
                'mime' => $image->mime()
            ]
        ];
    }

    protected function processVideo()
    {
        $path = 'multimedia/videos/' . date('Y/m');
        if (!file_exists(storage_path('app/public/' . $path))) {
            mkdir(storage_path('app/public/' . $path), 0755, true);
        }

        $fileName = uniqid() . '.' . $this->file->getClientOriginalExtension();
        $filePath = $path . '/' . $fileName;

        // Guardar video original
        $this->file->storeAs('public/' . $path, $fileName);

        // Generar thumbnail usando FFmpeg
        $ffmpeg = FFMpeg::create();
        $video = $ffmpeg->open(storage_path('app/public/' . $filePath));
        
        $thumbnailPath = $path . '/thumb_' . uniqid() . '.jpg';
        $video->frame(TimeCode::fromSeconds(1))
              ->save(storage_path('app/public/' . $thumbnailPath));

        return [
            'path' => $filePath,
            'thumbnail' => $thumbnailPath,
            'type' => 'video',
            'metadata' => [
                'duration' => $video->getStreams()->first()->get('duration'),
                'mime' => $this->file->getMimeType()
            ]
        ];
    }

    protected function processAudio()
    {
        $path = 'multimedia/audio/' . date('Y/m');
        if (!file_exists(storage_path('app/public/' . $path))) {
            mkdir(storage_path('app/public/' . $path), 0755, true);
        }

        $fileName = uniqid() . '.' . $this->file->getClientOriginalExtension();
        $filePath = $path . '/' . $fileName;

        // Guardar audio
        $this->file->storeAs('public/' . $path, $fileName);

        return [
            'path' => $filePath,
            'type' => 'audio',
            'metadata' => [
                'mime' => $this->file->getMimeType(),
                'size' => $this->file->getSize()
            ]
        ];
    }

    protected function processDocument()
    {
        $path = 'multimedia/documents/' . date('Y/m');
        if (!file_exists(storage_path('app/public/' . $path))) {
            mkdir(storage_path('app/public/' . $path), 0755, true);
        }

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