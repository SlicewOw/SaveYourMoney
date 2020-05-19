const delete_button = document.getElementById('delete-button');

if (delete_button) {

    delete_button.addEventListener(
        'click',
        function (e) {
            if (confirm("Are you sure?")) {

                const account_id = e.target.getAttribute('data-id');

                fetch(
                    `/account/delete/${account_id}`,
                    {
                        method: 'DELETE'
                    }
                ).then(result => window.open('/accounts'));

            }
        }
    );

}
