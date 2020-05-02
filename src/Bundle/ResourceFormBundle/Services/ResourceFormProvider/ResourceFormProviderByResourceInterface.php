<?php

namespace MMC\User\Bundle\ResourceFormBundle\Services\ResourceFormProvider;

interface ResourceFormProviderByResourceInterface
{
    public function findUserByResource($resource);
}
