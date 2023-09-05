@extends('layouts.user_type.auth')

@section('content')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function updateCurrentTrack() {
            $.ajax({
                url: '/spotify-getCurrentTrack', // API route URL
                method: 'GET',
                success: function (data) {
                    // Update the view with the latest track information
                    $('#track-name').text(data.current_track.name);
                    $('#artist-name').text(data.current_track.artists);

                    // Update album art if it's not the current track.
                    var albumArt = document.getElementById('album-art');
                    if (!(albumArt.src === data.current_track.imageUrl)) {
                        albumArt.src = data.current_track.imageUrl;
                    }

                },
                error: function (xhr, status, error) {
                    // Handle errors if necessary
                    console.error(xhr.responseText);
                }
            });
        }

        // Call the updateCurrentTrack function when the page loads
        updateCurrentTrack();

        // Periodically call the updateCurrentTrack function (e.g., every 5 seconds)
        setInterval(updateCurrentTrack, 1000); // 5000 milliseconds = 5 seconds
    </script>
{{--    <div class="col-lg-7 mb-lg-0 mb-4">--}}
{{--        <div id="current-track" class="card">--}}
{{--            <div class="card-body p-3">--}}
{{--                <div class="row">--}}
{{--                    <div class="col-lg-6">--}}
{{--                        <div class="d-flex flex-column h-300">--}}
{{--                            <p id="artist-name" class="mb-1 pt-2 text-bold"></p>--}}
{{--                            <h5 id="track-name" class="font-weight-bolder"></h5>--}}
{{--                            <a class="text-body text-sm font-weight-bold mb-0 icon-move-right mt-auto" href="javascript:;">--}}
{{--                                Read More--}}
{{--                                <i class="fas fa-arrow-right text-sm ms-1" aria-hidden="true"></i>--}}
{{--                            </a>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div class="col-lg-5 ms-auto text-center mt-5 mt-lg-0 d-flex flex-column h-300 w-300">--}}
{{--                        <img id="album-art" src="" class="position-absolute h-300 w-300 top-0 d-lg-block d-none" alt="">--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
    <div class="col-lg-5 mb-lg-0 mb-4">
        <div class="card">
            <div class="card-body p-3">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="d-flex flex-column h-100">
                            <p id="artist-name" class="mb-1 pt-2 text-bold"></p>
                            <h5 id="track-name" class="font-weight-bolder"></h5>
                            <div class="row mt-auto align-items-center justify-content-center border-1">
                                <div class="col-lg-2">
                                    <div class="d-flex flex-column">
                                        <i class="fa fa-backward text-dark text-gradient text-lg top-0"></i>
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="d-flex flex-column">
                                        <i class="fa fa-play text-dark text-gradient text-lg top-0"></i>
    {{--                                    <i class="fa fa-pause text-dark text-gradient text-lg top-0"></i>--}}
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="d-flex flex-column">
                                        <i class="fa fa-forward text-dark text-gradient text-lg top-0"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 ms-auto text-center mt-5 mt-lg-0">
                        <img id="album-art" class="border-radius-lg w-100 position-relative z-index-2" src="" alt="rocket">
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
