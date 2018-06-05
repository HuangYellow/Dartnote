<?php

namespace App\Presenters;

class PostPresenter
{
    private function regexUrls($content)
    {
        return preg_replace('/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/', '<a target="_blank" href="$0">$0</a>', $content);
    }

    private function regexTags($content)
    {
        return preg_replace('/\s#([\w-]+)/u', '<a href="/tags/$1">#$1</a>', $content);
    }

    public function content($content)
    {
        // 先過濾危險 tags.
        $content = $this->regexTags(e($content));

        // 加入 link 不過濾
        $content = $this->regexUrls($content);

        return nl2br($content);
    }

    public function escape($content)
    {
        return nl2br(e($content));
    }
}
