<?php

namespace Plugins\Media\src\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Plugins\Media\src\Models\MediaFile;

class MediaCreated
{
    use Dispatchable, SerializesModels;

    /**
     * The uploaded media instance.
     *
     * @var MediaFile
     */
    public MediaFile $media;

    /**
     * Create a new event instance.
     *
     * @param MediaFile $media
     */
    public function __construct(MediaFile $media)
    {
        $this->media = $media;
    }

}
