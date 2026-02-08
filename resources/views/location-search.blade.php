<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Location Search</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .suggestions-container {
            position: absolute;
            width: 100%;
            max-height: 200px;
            overflow-y: auto;
            background: white;
            border: 1px solid #ddd;
            border-radius: 4px;
            z-index: 1000;
        }
        .suggestion-item {
            padding: 8px 12px;
            cursor: pointer;
        }
        .suggestion-item:hover {
            background-color: #f8f9fa;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="text-center">Location Search</h3>
                    </div>
                    <div class="card-body">
                        <form id="locationSearchForm">
                            <div class="form-group position-relative">
                                <label for="location">Enter Location</label>
                                <input type="text" 
                                       class="form-control" 
                                       id="location" 
                                       name="location" 
                                       placeholder="Type to search locations..."
                                       autocomplete="off">
                                <div id="suggestions" class="suggestions-container d-none"></div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            let searchTimeout;
            const suggestionsContainer = $('#suggestions');
            const locationInput = $('#location');

            locationInput.on('input', function() {
                const searchTerm = $(this).val();
                
                // Clear previous timeout
                clearTimeout(searchTimeout);
                
                if (searchTerm.length < 2) {
                    suggestionsContainer.addClass('d-none');
                    return;
                }

                // Set new timeout
                searchTimeout = setTimeout(() => {
                    $.get('/api/location-suggestions', { term: searchTerm })
                        .done(function(response) {
                            if (response && response.length > 0) {
                                let suggestionsHtml = '';
                                response.forEach(function(suggestion) {
                                    suggestionsHtml += `<div class="suggestion-item">${suggestion.DisplayText}</div>`;
                                });
                                suggestionsContainer.html(suggestionsHtml).removeClass('d-none');
                            } else {
                                suggestionsContainer.addClass('d-none');
                            }
                        })
                        .fail(function(error) {
                            console.error('Error fetching suggestions:', error);
                            suggestionsContainer.addClass('d-none');
                        });
                }, 300);
            });

            // Handle suggestion click
            suggestionsContainer.on('click', '.suggestion-item', function() {
                locationInput.val($(this).text());
                suggestionsContainer.addClass('d-none');
            });

            // Hide suggestions when clicking outside
            $(document).on('click', function(e) {
                if (!$(e.target).closest('.form-group').length) {
                    suggestionsContainer.addClass('d-none');
                }
            });
        });
    </script>
</body>
</html> 