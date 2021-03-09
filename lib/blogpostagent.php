<?php

namespace Nizamov\BlogPostFormExt;

use Bitrix\Main\Loader;
use Bitrix\Socialnetwork\ComponentHelper;

class BlogPostAgent
{

    /**
     * Агент,отрабатывается каждую минуту.
     * Используется для автоматической публикации постов со статусом черновик при наступлении дату публикации.
     *
     * @return string
     */
    public function checkDraftPosts()
    {
        Loader::includeModule("blog");
        Loader::includeModule("socialnetwork");

        $dbPosts = \CBlogPost::GetList(
            ['ID' => 'ASC'],
            [
                'PUBLISH_STATUS' => BLOG_PUBLISH_STATUS_DRAFT,
                '<=DATE_PUBLISH' => date('d.m.Y H:i:s'),
            ]
        );

        if ($arPost = $dbPosts->Fetch()) {
            $id = \CBlogPost::Update(
                $arPost["ID"],
                [
                    'PUBLISH_STATUS' => BLOG_PUBLISH_STATUS_PUBLISH,
                    "SOCNET_RIGHTS"  => ["UA", "G2"],
                ]
            );

            \CBlogPost::notifyImPublish(
                [
                    "TYPE"       => "POST",
                    "TITLE"      => $arPost["TITLE"],
                    "TO_USER_ID" => $arPost["AUTHOR_ID"],
                    "POST_ID"    => $id,
                ]
            );
        }

        return "\Nizamov\BlogPostFormExt\BlogPostAgent::checkDraftPosts();";
    }

}


