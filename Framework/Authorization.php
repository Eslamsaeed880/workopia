<?php

namespace Framework;

use Framework\Session;

class Authorization {
    /**
     * Check if current logged in user owns a resource
     * 
     * @param int $resourceUserId
     * @return bool
     */
    public static function isOwner($resourceUserId) {
        $currentUser = Session::get('user');
        return $currentUser && $currentUser['id'] === $resourceUserId;
    }
}