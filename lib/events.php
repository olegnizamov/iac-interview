<?php

namespace Nizamov\BlogPostFormExt;

class Events
{
    /**
     * Событие подключение js библиотеки в эпилоге.
     */
    public function onEpilogEvent()
    {
        \CJSCore::RegisterExt(
            'blogpostform',
            [
                'js' => '/local/modules/nizamov.blogpostformext/js_libs/blogpostform.js',
            ]
        );
        \CUtil::InitJSCore(['blogpostform']);
    }
}


