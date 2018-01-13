<?php

namespace App\Traits;

trait Cloutable {

    public function clout_posts() {
        $posts = \App\Post::where('user_id', $this->id);

        return $posts;
    }

    public function clout_posts_count() {
        $count = \App\Post::where('user_id', $this->id)->count();

        return $count;
    }

    public function clout_photos_count() {
        $total_photos = 0;
        if( $this->clout_posts_count() > 0) {
            $posts = $this->clout_posts();
            foreach($posts as $post):
                $total_photos += 1;
            endforeach;
        }
        return $total_photos;
    }
}