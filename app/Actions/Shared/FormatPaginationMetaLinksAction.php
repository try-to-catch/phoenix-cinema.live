<?php

namespace App\Actions\Shared;

/**
 * This action is used to format the pagination meta links in particular the first and last page links
 */
class FormatPaginationMetaLinksAction
{
    public function handle(array $meta): array
    {
        $meta[0]['label'] = '&laquo;';
        $meta[count($meta) - 1]['label'] = '&raquo;';

        return $meta;
    }
}
