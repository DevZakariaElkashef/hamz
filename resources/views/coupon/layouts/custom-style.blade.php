<style>
    .custom-toggle-switch {
        position: relative;
        display: inline-block;
        width: 50px;
        height: 26px;
    }

    .custom-toggle-input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    .custom-toggle-slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        transition: 0.4s;
        border-radius: 34px;
    }

    .custom-toggle-slider:before {
        position: absolute;
        content: "";
        height: 22px;
        width: 22px;
        left: 2px;
        bottom: 2px;
        background-color: white;
        transition: 0.4s;
        border-radius: 50%;
    }

    .custom-toggle-input:checked+.custom-toggle-slider {
        background-color: #4CAF50;
        /* Green when active */
    }

    .custom-toggle-input:not(:checked)+.custom-toggle-slider {
        background-color: #FF6347;
        /* Red when inactive */
    }

    .custom-toggle-input:checked+.custom-toggle-slider:before {
        transform: translateX(24px);
    }

    .custom-toggle-input:not(:checked)+.custom-toggle-slider:before {
        transform: translateX(0px);
    }

    /* Custom Select Dropdown Styles */
    .custom-select-wrapper {
        position: relative;
        display: inline-block;
        width: 120px;
        /* Adjust width as needed */
    }

    .custom-select {
        background-color: #ffffff;
        border: 1px solid #ced4da;
        border-radius: 0.25rem;
        padding: 0.5rem 1rem;
        font-size: 0.875rem;
        /* Smaller font size for compact appearance */
        color: #495057;
        cursor: pointer;
        appearance: none;
        width: 100%;
        box-sizing: border-box;
        /* Ensures padding and border are included in the width */
        overflow: hidden;
        /* Hide overflow to prevent text from extending outside */
        text-overflow: ellipsis;
        /* Show ellipsis for text overflow */
        white-space: nowrap;
        /* Prevent text from wrapping */
    }

    /* Custom Arrow */
    .custom-select::after {
        content: "\f078";
        /* FontAwesome arrow */
        font-family: 'FontAwesome';
        position: absolute;
        top: 50%;
        right: 10px;
        transform: translateY(-50%);
        pointer-events: none;
        color: #495057;
    }

    /* Adjust for the wrapper */
    .custom-select-wrapper {
        position: relative;
    }

    .custom-select::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        border: 1px solid #ced4da;
        border-radius: 0.25rem;
        pointer-events: none;
        z-index: 1;
    }
</style>
