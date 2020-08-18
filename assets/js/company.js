import $ from 'jquery';


function addTagForm($collectionHolder, $newLinkLi) {

    var prototype = $collectionHolder.data('prototype');

    // get the new index
    var index = $collectionHolder.data('index');

    var newForm = prototype;
    newForm = newForm.replace(/__name__/g, index);

    // increase the index with one for the next item
    $collectionHolder.data('index', index + 1);

    // Display the form in the page in an li, before the "Add a contact" link li
    var $newFormLi = $('<li></li>').append(newForm);
    $newLinkLi.before($newFormLi);
    addTagFormDeleteLink($newFormLi);
}

function addTagFormDeleteLink($tagFormLi) {
    var $removeFormButton = $('<div><button type="button">Delete this contact</button></div>');
    $tagFormLi.append($removeFormButton);

    $removeFormButton.on('click', function(e) {
        // remove the li for the tag form
        $tagFormLi.remove();
    });
}

$(function () {

    $('#delete_logo').click(function () {
        $('#company_is_delete_logo').val(1);
        $('#a_logo').remove();
    });

    $('#company_time_work_from, #company_time_work_to').timepicker();

    $("#company_director").select2({
        width:'180px',
        ajax: {
            url: "/profile/search",
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    q: params.term
                };
            },
            processResults: function (data) {
                return {
                    results: data.items
                };
            },
            cache: true
        },
        placeholder: 'Search for a director',
        minimumInputLength: 0,
        templateResult: formatRepo,
        templateSelection: formatRepoSelection
    })

    function formatRepo (repo) {
        if (repo.loading) {
            return repo.text;
        }
        return repo.full_name;
    }
    function formatRepoSelection (repo) {
        return repo.full_name || repo.text;
    }

    var $collectionHolder;

    // setup an "add a tag" link
    var $addTagButton = $('.add_contact');
    var $newLinkLi = $('<li></li>').append($addTagButton);

    // Get the ul that holds the collection of tags
    $collectionHolder = $('.companyContacts');

    $collectionHolder.find('li').each(function() {
        addTagFormDeleteLink($(this));
    });

    // add the "add a tag" anchor and li to the tags ul
    $collectionHolder.append($newLinkLi);

    // count the current form inputs we have (e.g. 2), use that as the new
    // index when inserting a new item (e.g. 2)
    $collectionHolder.data('index', $collectionHolder.find('input').length);

    $addTagButton.on('click', function(e) {
        // add a new tag form (see next code block)
        addTagForm($collectionHolder, $newLinkLi);
    });

});