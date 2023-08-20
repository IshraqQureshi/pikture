@php $editing = isset($photo) @endphp

@extends('layouts.app')

@section('content')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/lightgallery@2.0.0-beta.3/css/lightgallery.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/lightgallery@2.0.0-beta.3/css/lg-zoom.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/justifiedGallery@3.8.1/dist/css/justifiedGallery.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/lightgallery@2.0.0-beta.3/css/lg-thumbnail.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">


    <style>
        .gallery-item {
            width: 200px;
            padding: 5px;
        }

        /* Copyright (c) 2022 Ivan Teplov */

        * {
            margin: 0;
            padding: 0;
        }

        :root {
            --background: #fff;
            --foreground: #000;
            --divider: #dcdcdc;
            --overlay: #888;
        }

        @media (prefers-color-scheme: dark) {
            :root {
                --background: #000;
                --foreground: #fff;
                --divider: #333;
            }
        }

        html,
        body {
            height: 100%;
        }

        body {
            background: var(--background);
            color: var(--foreground);

            line-height: 1.5;

            -webkit-tap-highlight-color: transparent;
        }

        button,
        input,
        textarea,
        [contenteditable="true"] {
            box-sizing: border-box;
            padding: 1rem;

            border-radius: 1rem;
            border: 0.0625rem solid var(--divider);

            font-family: inherit;
            font-size: 1rem;

            background: var(--background);
            color: var(--foreground);
        }

        textarea {
            resize: none;
        }

        button {
            cursor: pointer;
        }

        .sheet {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: flex-end;

            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            z-index: 2000;
            visibility: visible;
            transition: opacity 0.5s, visibility 0.5s;
        }

        .sheet[aria-hidden="true"] {
            opacity: 0;
            visibility: hidden;
            pointer-events: none;
        }

        .sheet .overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            z-index: -1;
            background: var(--overlay);
            opacity: 0.5;
        }

        .sheet .contents {
            display: flex;
            flex-direction: column;

            border-radius: 1rem 1rem 0 0;

            background: var(--background);

            overflow-y: hidden;

            --default-transitions: transform 0.5s, border-radius 0.5s;

            transition: var(--default-transitions);
            transform: translateY(0);

            width: 30rem;
            max-width: 70rem;
            max-height: 100vh;
            height: 30vh;

            box-sizing: border-box;
        }

        @media only screen and (max-width: 768px) {
            .sheet .contents {
                width: 100% !important;
            }
        }

        .sheet .contents:not(.not-selectable) {
            transition: var(--default-transitions), height 0.5s;
        }

        .sheet .contents.fullscreen {
            border-radius: 0;
        }

        .sheet[aria-hidden="true"] .contents {
            transform: translateY(100%);
        }

        .sheet .controls {
            display: flex;
        }

        .sheet .draggable-area {
            width: 3rem;
            margin: auto;
            padding: 1rem;
            cursor: grab;
        }

        .sheet .draggable-thumb {
            width: inherit;
            height: 0.25rem;
            background: var(--divider);
            border-radius: 0.125rem;
        }

        .sheet .close-sheet {
            border: none;
            padding: 0.7rem;
        }

        .sheet .body {
            flex-grow: 1;
            height: 100%;

            display: flex;
            flex-direction: column;

            overflow-y: auto;
            gap: 1rem;

            padding: 1rem;
            box-sizing: border-box;
        }

        form {
            gap: 1rem;
        }

        .centered-message {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100%;
        }

        .comment-input {
            display: flex;
            align-items: center;
        }

        #commentInput {
            flex: 1;
            margin-right: 10px;
        }

        .comment-button {
            flex-shrink: 0;
        }
        .gallery-item{
            display: inline-flex;
            width: calc(100% / 2 - 2px);
            flex-direction: column;
            align-items: center;
        }
        .addToCart{
            display: inline-flex;
            padding: 10px 20px;
            background: #0d6efd;
            margin-top: 10px;
            text-decoration: none;
            text-transform: uppercase;
            letter-spacing: 4px;
            font-weight: 700;
            border-radius: 4px;
            color: #fff;
            transition: 0.5s ease opacity
        }
        .addToCart:hover{
            opacity: 0.8;
            color: #fff;
        }

        img{
            max-width: 100%;
            pointer-events: none
        }
    </style>
    <div class="container">
        <div class="searchbar mt-0 mb-4">
            <div class="row">
                <div class="col-md-6">

                </div>
                <div class="col-md-6 text-right">
                    <form action="{{ route('event.gallery') }}" method="GET">
                        @can('viewGallery', App\Models\Photo::class)
                            <x-inputs.select name="event_id" label="Event" required>
                                <option value="all" {{ empty($selectedEvent) ? 'selected' : '' }}>All</option>

                                @role('user')
                                    @foreach ($events as $event)
                                        <option value="{{ $event->id }}"
                                            {{ isset($selectedEvent) && $selectedEvent == $event->id ? 'selected' : '' }}>
                                            {{ $event->gallery_name }}
                                        </option>
                                    @endforeach
                                    @elserole('super-admin')
                                    @foreach ($events as $value => $label)
                                        <option value="{{ $value }}"
                                            {{ isset($selectedEvent) && $selectedEvent == $value ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                @else
                                    @foreach ($events as $value => $label)
                                        <option value="{{ $label->id }}"
                                            {{ isset($selectedEvent) && $selectedEvent == $value ? 'selected' : '' }}>
                                            {{ $label->gallery_name }}
                                        </option>
                                    @endforeach
                                @endrole
                            </x-inputs.select>
                        @endcan
                        <button class="btn btn-primary mt-2" type="submit">
                            <i class="icon ion-md-search"></i> @lang('crud.common.search')
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div style="display: flex; justify-content: space-between;">
                    <h4 class="card-title">Gallery</h4>
                    {{-- <button type="button" id="open-sheet" aria-controls="sheet">Open Sheet</button> --}}
                </div>
                {{-- <div class="container-sm">
                    <div class="row justify-content-center">
                      <div class="col col-md-10">
                        <div class="gallery-container" id="animated-thumbnails-gallery">
                            @foreach ($photos as $photo)
                            <a data-src="{{ $photo->photo ? \Storage::url($photo->photo) : '' }}">
                              <img alt="layers of blue." class="img-responsive" src="{{ $photo->photo ? \Storage::url($photo->photo) : '' }}" />
                            </a>
                            @endforeach
                        </div>
                      </div>
                    </div>
                  </div> --}}

                <div class="container-sm">
                    <div class="row justify-content-center">
                        <div class="col col-md-12">
                            <div class="gallery-container">
                                @foreach ($photos as $photo)
                                    <div class="gallery-item">
                                        <a data-lg-size="" data-photoid="{{ $photo->id }}"
                                            data-src="{{ $photo->photo ? \Storage::url($photo->photo) : '' }}">
                                            <img alt="Event: {{ $photo->event->gallery_name }}"
                                                class="img-responsive lg-current"
                                                src="{{ $photo->photo ? \Storage::url($photo->photo) : '' }}" />
    
                                        </a>
                                        <a href="{{ route('order.addToCart', ['id' => $photo->id]) }}" class="addToCart">Add to Cart</a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <div id="sheet" class="sheet" aria-hidden="true" role="dialog">
                    <div class="overlay"></div>
                    <div class="contents">
                        <header class="controls">
                            <div class="draggable-area">
                                <div class="draggable-thumb"></div>
                            </div>
                            <button class="close-sheet" type="button" title="Close the sheet">&times;</button>
                        </header>
                        <main class="body">
                            <h5 class="text-center">Comments</h5>
                            <div id="commentsContainer"></div>
                        </main>
                        @can('create', App\Models\Comment::class)
                            <footer class="comment-footer">
                                <div class="comment-input">
                                    <input id="commentInput" type="text" placeholder="Write a comment">
                                    <button id="submitComment" type="button" class="comment-button">&#10148;</button>
                                </div>
                            @endcan
                        </footer>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/lightgallery@2.0.0-beta.3/lightgallery.umd.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/lightgallery@2.0.0-beta.3/plugins/zoom/lg-zoom.umd.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/justifiedGallery@3.8.1/dist/js/jquery.justifiedGallery.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/lightgallery@2.0.0-beta.3/plugins/thumbnail/lg-thumbnail.umd.js"></script>
    <script>
        $(document).ready(function() {
            jQuery("#animated-thumbnails-gallery")
                .justifiedGallery({
                    captions: false,
                    rowHeight: 180,
                    margins: 5,
                    thumbnail: true,
                })
                .on("jg.complete", function() {
                    const lgInstance = window.lightGallery(
                        document.getElementById("animated-thumbnails-gallery"), {
                            autoplayFirstVideo: false,
                            pager: false,
                            plugins: [lgZoom, lgThumbnail],
                            mobileSettings: {
                                controls: false,
                                showCloseIcon: true,
                                download: true,
                                rotate: false
                            },
                        }
                    );

                    // Create a new button element
                    var commentButton = document.createElement("button");
                    commentButton.id = "open-sheet";
                    commentButton.type = "button";
                    commentButton.classList.add("lg-custom-share-button", "lg-icon");

                    var commentIcon = document.createElement("i");
                    commentIcon.classList.add("fa", "fa-comments"); // Assuming you are using Font Awesome
                    commentButton.appendChild(commentIcon);

                    // Append the new button to the lightgallery toolbar
                    var toolbar = document.querySelector(".lg-toolbar");
                    toolbar.appendChild(commentButton);

                    commentButton.addEventListener("click", openSheet);
                    // comment button end


                    // bottom sheet start
                    const $ = document.querySelector.bind(document)

                    const openSheetButton = $("#open-sheet")
                    const sheet = $("#sheet")
                    const sheetContents = sheet.querySelector(".contents")
                    const draggableArea = sheet.querySelector(".draggable-area")
                    const photoNameElement = document.createElement("h2")
                    // const commentsContainer = document.createElement("div")

                    let sheetHeight // in vh

                    const setSheetHeight = (value) => {
                        sheetHeight = Math.max(0, Math.min(100, value))
                        sheetContents.style.height = `${sheetHeight}vh`

                        if (sheetHeight === 100) {
                            sheetContents.classList.add("fullscreen")
                        } else {
                            sheetContents.classList.remove("fullscreen")
                        }
                    }

                    const setIsSheetShown = (isShown) => {
                        sheet.setAttribute("aria-hidden", String(!isShown))
                    }
                    // Function to fetch and display comments
                    async function fetchAndDisplayComments(photoId) {
                        try {
                            // Fetch the comments for the photo
                            var response = await fetch(`/get-comments?photoID=${photoId}`);
                            var data = await response.json();
                            // console.log(data);

                            // Open the bottom sheet and display the comments
                            setSheetHeight(50); // Set the desired height of the sheet
                            setIsSheetShown(true);

                            let commentsContainer = document.getElementById("commentsContainer");
                            // Clear existing comments
                            commentsContainer.innerHTML = "";
                            if (data.comments.length === 0) {
                                var noCommentsElement = document.createElement("div");
                                noCommentsElement.textContent = "No comments";
                                noCommentsElement.classList.add(
                                    "centered-message"); // Add CSS class for center alignment
                                commentsContainer.appendChild(noCommentsElement);
                            } else {
                                data.comments.forEach(function(comment) {
                                    // Replace 'comment.comment' with the actual property name in the data object that represents the comment text

                                    // Access the user name from the comment object
                                    var user = comment.user.name;

                                    var commentElement = document.createElement("div");

                                    var userElement = document.createElement("strong");
                                    userElement.textContent = user;
                                    commentElement.appendChild(userElement);

                                    commentElement.appendChild(document.createElement(
                                        "br")); // Add line break

                                    var commentTextElement = document.createElement("span");
                                    commentTextElement.textContent = comment.comment;
                                    commentElement.appendChild(commentTextElement);

                                    commentsContainer.appendChild(commentElement);
                                });
                            }
                        } catch (error) {
                            console.error("Error retrieving comments:", error);
                        }
                    }

                    async function openSheet() {
                        // Get the index of the currently opened lightgallery item
                        const currentIndex = lgInstance.index;

                        // Get the URL of the currently opened lightgallery item
                        const currentItem = document.querySelectorAll(".gallery-item")[currentIndex];
                        const photoId = currentItem.getAttribute("data-photoid");
                        // console.log(photoId);

                        // Fetch and display the comments
                        await fetchAndDisplayComments(photoId);

                        // Open the bottom sheet
                        setSheetHeight(50); // Set the desired height of the sheet
                        setIsSheetShown(true);
                    }


                    openSheetButton.addEventListener("click", () => {
                        setSheetHeight(Math.min(50, 720 / window.innerHeight * 100));
                        setIsSheetShown(true);
                    });

                    sheet.querySelector(".close-sheet").addEventListener("click", () => {
                        setIsSheetShown(false);
                    });

                    sheet.querySelector(".overlay").addEventListener("click", () => {
                        setIsSheetShown(false);
                    });

                    const isFocused = (element) => document.activeElement === element;

                    window.addEventListener("keyup", (event) => {
                        const isSheetElementFocused =
                            sheet.contains(event.target) && isFocused(event.target);

                        if (event.key === "Escape" && !isSheetElementFocused) {
                            setIsSheetShown(false);
                        }
                    });

                    const touchPosition = (event) =>
                        event.touches ? event.touches[0] : event;

                    let dragPosition;

                    const onDragStart = (event) => {
                        dragPosition = touchPosition(event).pageY;
                        sheetContents.classList.add("not-selectable");
                        draggableArea.style.cursor = document.body.style.cursor = "grabbing";
                    };

                    const onDragMove = (event) => {
                        if (dragPosition === undefined) return;

                        const y = touchPosition(event).pageY;
                        const deltaY = dragPosition - y;
                        const deltaHeight = (deltaY / window.innerHeight) * 100;

                        setSheetHeight(sheetHeight + deltaHeight);
                        dragPosition = y;
                    };

                    const onDragEnd = () => {
                        dragPosition = undefined;
                        sheetContents.classList.remove("not-selectable");
                        draggableArea.style.cursor = document.body.style.cursor = "";

                        if (sheetHeight < 25) {
                            setIsSheetShown(false);
                        } else if (sheetHeight > 75) {
                            setSheetHeight(100);
                        } else {
                            setSheetHeight(50);
                        }
                    };

                    draggableArea.addEventListener("mousedown", onDragStart);
                    draggableArea.addEventListener("touchstart", onDragStart);

                    window.addEventListener("mousemove", onDragMove);
                    window.addEventListener("touchmove", onDragMove);

                    window.addEventListener("mouseup", onDragEnd);
                    window.addEventListener("touchend", onDragEnd);




                    // Create a new button element
                    var shareButton = document.createElement("button");
                    shareButton.id = "custom-share-button";
                    shareButton.type = "button";
                    shareButton.classList.add("lg-custom-share-button", "lg-icon");

                    // Create an <i> element for the icon
                    var shareIcon = document.createElement("i");
                    shareIcon.classList.add("fa", "fa-share-alt"); // Assuming you are using Font Awesome
                    shareButton.appendChild(shareIcon);
                    // Append the new button to the lightgallery toolbar
                    var toolbar = document.querySelector(".lg-toolbar");
                    toolbar.appendChild(shareButton);

                    // Add an onclick event listener to the custom button
                    shareButton.onclick = shareImage;

                    // Function to share the image using navigator.share
                    async function shareImage() {
                        // Get the index of the currently opened lightgallery item
                        const currentIndex = lgInstance.index;

                        // Get the URL of the currently opened lightgallery item
                        const currentItem = document.querySelectorAll(".gallery-item")[currentIndex];
                        const imageUrl = currentItem.getAttribute('data-src');

                        try {
                            // Fetch the image blob
                            const response = await fetch(imageUrl);
                            const blob = await response.blob();

                            // Create a file from the blob
                            const file = new File([blob], 'image.jpg', {
                                type: 'image/jpeg'
                            });

                            // Check if navigator.share is supported
                            if (navigator.share) {
                                // Share the file using navigator.share
                                await navigator.share({
                                    files: [file]
                                });
                            } else {
                                // Handle the case when navigator.share is not supported
                                alert('Sharing is not supported in this browser');
                                // Perform an alternative action here if needed
                            }
                        } catch (error) {
                            console.error('Error sharing image:', error);
                        }
                    }
                    // const $ = document.querySelector.bind(document)


                    document.getElementById("submitComment").addEventListener("click", async () => {
                        const currentIndex = lgInstance.index;
                        const currentItem = document.querySelectorAll(".gallery-item")[
                            currentIndex];
                        const photoId = currentItem.getAttribute("data-photoid");
                        // console.log(photoId);

                        var comment = $('#commentInput').value;

                        // Retrieve the CSRF token from the meta tag
                        var csrfToken = document.querySelector('meta[name="csrf-token"]')
                            .getAttribute('content');

                        if (comment.trim() === '') {
                            // Comment input is empty, disable the arrow button
                            return;
                        }

                        try {
                            // Send the comment data to the server
                            var response = await fetch('/comments', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': csrfToken // Include the CSRF token in the headers
                                },
                                body: JSON.stringify({
                                    comment: comment,
                                    photo_id: photoId
                                })
                            });

                            if (response.ok) {
                                // Comment submitted successfully
                                console.log('Comment submitted successfully');
                                await fetchAndDisplayComments(photoId);
                                document.getElementById('commentInput').value =
                                    ''; // Clear the input field

                                // Scroll the newly added comment into view
                                const commentsContainer = document.getElementById(
                                    "commentsContainer");
                                const newComment = commentsContainer.lastElementChild;
                                newComment.scrollIntoView({
                                    behavior: 'smooth',
                                    block: 'end'
                                });
                            } else {
                                throw new Error(
                                    'Comment submission failed. Server responded with status: ' +
                                    response.status);
                            }
                        } catch (error) {
                            console.error('Comment submission failed:', error);
                        }
                    });




                });
        });
    </script>

@endsection
