<?php

namespace Modules\Blog\services;


use Illuminate\Support\Facades\Storage;
use Modules\Blog\Models\Article;
use Modules\core\services\BaseService;

class ArticleService extends BaseService
{

        public function __construct(Article $article)
        {
            parent::__construct($article);
        }

}