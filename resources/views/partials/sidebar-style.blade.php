<style>
    details > summary {
        list-style: none; /* Remove default list icon */
    }

    details > summary::-webkit-details-marker {
        display: none; /* Remove default arrow for Chrome and Safari */
    }

    details > summary .rotate-0 {
        transition: transform 0.2s ease-in-out;
    }

    details[open] > summary .rotate-0 {
        transform: rotate(180deg); /* Rotates the arrow 180 degrees when details is open */
    }

    /* Standard scrollbar settings for Firefox */
    * {
        scrollbar-width: thin;
        scrollbar-color: #b83280 #f8f9fa; /* Thumb and track colors */
    }

    /* Custom scrollbar for Chrome, Edge, and Safari */
    *::-webkit-scrollbar {
        width: 12px; /* Consistent width for stability */
    }

    *::-webkit-scrollbar-track {
        background: lightpink; /* Very light grey for the track */
        border-radius: 10px; /* Rounded corners for a modern look */
    }

    *::-webkit-scrollbar-thumb {
        background-color: #b83280; /* Bright blue for the thumb */
        border-radius: 10px;
        border: 4px solid pink; /* Light grey border to match the track */
    }

    *::-webkit-scrollbar-thumb:hover {
        background-color: #b83280; /* Darker blue on hover for feedback */
    }

    #toggleSidebarMobile:checked ~ #sidebar {
        display: flex;
    }

    #toggleSidebarMobile:checked ~ nav label #toggleSidebarMobileHamburger {
        display: none;
    }

    #toggleSidebarMobile:checked ~ nav label #toggleSidebarMobileClose {
        display: block;
    }

</style>

