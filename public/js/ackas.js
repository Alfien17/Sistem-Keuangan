var path = "{{ route('autocompletekas') }}";
            $('input.typeahead').typeahead({
                source:  function (terms, process) 
                {
                return $.get(path, { terms: terms }, function (data) {
                        return process(data);
                    });
                }
            });