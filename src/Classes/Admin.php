<?php

namespace Danupe\Plugin\User\Classes;

class Admin
{

    public function getPrefix()
    {
        return danupe()->env()->get("DANUPE_ADMIN_PREFIX");
    }
}
