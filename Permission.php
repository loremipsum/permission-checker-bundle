<?php

namespace LoremIpsum\PermissionCheckerBundle;

interface Permission
{
    /**
     * @return bool|null
     */
    public function preCheck();

    /**
     * @return bool
     */
    public function isGranted();

    /**
     * @param PermissionChecker $checker
     * @return void
     */
    public function setPermissionChecker(PermissionChecker $checker);

    /**
     * @return string
     */
    public function getAction();
}
