<?php

namespace App\Service\Lead;

interface LeadApiServiceInterface
{
    public function getLeads();

    public function getLinkedProductsByLeadId(int $id);
}
