@if (!empty($favoritesUsersData['users']))

    @foreach ($favoritesUsersData['users'] as $item)

        <div class="grid-x grid-margin-x">
            <div class="cell small-12 medium-12 userInfoLeft">
                @include("frontend.partials.pages.profile.about-heading",
                    [
                        "userId"            => $item['id'],
                        "imageUrl"          => $item['profile_picture'],
                        "online"            => "1",
                        "aboutName"         => $item['name'],
                        "username"          => $item['username'],
                        "profession"        => $item['profession'],
                        "verified"          => 0,
                        "rating"            => $item['rating'] ?? 0,
                        "folowers"          => $item['total_followers'],
                        "followButton"      => "1",
                        "favoriteButton"    => "1"
                    ]
                )
            </div>



        </div>
    @endforeach
@endif
