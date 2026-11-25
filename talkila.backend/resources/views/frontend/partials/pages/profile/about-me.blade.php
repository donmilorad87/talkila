<section class="cell small-12">
    @include("frontend.partials.pages.profile.about-heading",
        [
            "userId"        => $userData['id'],
            "imageUrl"      => $userData['profile_picture'],
            "online"        => "0",
            "aboutName"     => $userData['name'],
            "username"      => $userData['username'],
            "profession"    => $userData['profession'],
            "verified"      => $userData['approved'],
            "rating"        => $userData['ratings'],
            "folowers"      => $userData['total_followers'],
            "followButton"  => $userData['following'],
            "favoriteButton"=>null
        ]
    )
</section>
