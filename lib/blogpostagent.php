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

        global $APPLICATION;
        $flagFindDraftPosts = false;

        $dbPosts = \CBlogPost::GetList(
            ['ID' => 'ASC'],
            [
                'PUBLISH_STATUS' => BLOG_PUBLISH_STATUS_DRAFT,
                //       '<=DATE_PUBLISH' => date('d.m.Y H:i:s'),
            ]
        );

        if ($arPost = $dbPosts->Fetch()) {
            $flagFindDraftPost = true;

            $id = \CBlogPost::Update(
                $arPost["ID"],
                [
                    'PUBLISH_STATUS' => BLOG_PUBLISH_STATUS_PUBLISH,
                    "SOCNET_RIGHTS"  => ["UA", "G2"],
                ]
            );

            BXClearCache(
                true,
                ComponentHelper::getBlogPostCacheDir(
                    [
                        'TYPE'    => 'post',
                        'POST_ID' => $id,
                    ]
                )
            );
            BXClearCache(
                true,
                ComponentHelper::getBlogPostCacheDir(
                    [
                        'TYPE'    => 'post_general',
                        'POST_ID' => $id,
                    ]
                )
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

        BXClearCache(
            true,
            ComponentHelper::getBlogPostCacheDir(
                [
                    'TYPE'    => 'posts_popular',
                    'SITE_ID' => SITE_ID,
                ]
            )
        );


        return "\Nizamov\BlogPostFormExt\BlogPostAgent::checkDraftPosts();";
    }

    private static function clearBlogPostCache(bool $full = false, array $arr): void
    {
        BXClearCache(
            true,
            ComponentHelper::getBlogPostCacheDir(
                $arr
            )
        );
    }


}


