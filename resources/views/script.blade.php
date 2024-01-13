<script>

// tinymce.init({selector:'textarea'});

$(document).ready(function() {
        $('#content').summernote({
            spellCheck: true
        });

});


function addBlogForm(value)
{
    if(value == 0)
    {
        $("#id").val('');
        $("#blogButton").text('Add Blog');
        $("#blogModal").modal('show');
        clearAll();
    }
    else if(value==2)
    {
        $("#blogModal").modal('show');
    }
    else
    {
        $("#blogModal").modal('hide');
    }

}

function clearAll()
{
    $("#blogForm")[0].reset();
    $('#blogForm').trigger("reset");
    $("#showImg").addClass('d-none');
    $("#content").summernote('code', '');
}

function saveBlog(e)
{
    e.preventDefault();

        let data = $("#blogForm")[0];
        const formData = new FormData(data);

        $.ajax({
            url: '{{ route('blogs.add') }}',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            beforeSend: function() {
                $('#blogButton').attr('disabled', 'disabled');
                $('#blogButton').text('Adding..');
            },
            complete: function() {
                $('#blogButton').attr("disabled", false);
                if ($("#id").val() != "" || $("#id").val() != null || $("#id").val() != undefined) {
                    console.log('sd');
                    $("#blogButton").text('Update Blog');
                } else {
                    $("#blogButton").text('Add Blog');
                }
            },
            success: function(data) {
                console.log(data);
                if (data.success == true) {
                    clearAll();
                    $('#blogForm').trigger("reset");
                    notify("success", data.message);
                    $('#blogTable').DataTable().ajax.reload();
                    $("#description").val('');
                    addBlogForm(1);

                } else {
                    notify("warning", data.message);
                }
            },
            error: function(data) {
                console.log(data);
                notify('danger',data.responseJSON.message);
            }
        });

}


function editBlog(id) {
        let url = "{{ route('blogs.getbyid', ':id') }}";
        url = url.replace(":id", id);
        $.ajax({
            url: url,
            type: 'GET',
            data: {
                '_token': '{{ csrf_token() }}'
            },
            success: function(output) {
                console.log(output);
                $("#showImg").removeClass('d-none');
                $(".modal-title").text("Update Blog");
                $("#blogButton").text("Update Blog");
                $('#id').val(output.id);
                $('#name').val(output.name);
                $('#date').val(output.date);
                $("#author").val(output.author);
                $("#imageShow").attr('src', `images1/${output.image}`);
                $("#content").summernote('code', output.content);
                addBlogForm(2);
            },
            error: function(data) {

            }
        });
    }

    function deleteBlog(id) {

        let route = "{{ route('blogs.delete', ':id') }}"
        route = route.replace(":id", id);
        $.confirm({
            title: 'Confirm Delete',
            content: 'Do you want to delete?',
            type: 'red',
            buttons: {
                tryAgain: {
                    text: 'CONFIRM',
                    //btnClass: 'btn-success',
                    keys: ['y'],
                    action: function() {
                        $.ajax({
                            url: route,
                            type: 'DELETE',
                            data: {
                                '_token': '{{ csrf_token() }}',
                            },
                            success: function(response) {
                                if (response.success == true) {
                                    $('#blogTable').DataTable().ajax.reload();
                                    notify('success', response.message);
                                } else {
                                    notify('warning', response.message);
                                }
                            },
                            error: function(jqXHR, status, err) {
                                notify('danger', 'Data under this section !');
                            }
                        });
                    }
                },
                cancel: {
                    keys: ['n'],
                    action: function() {

                    }
                }
            }
        });
    }

</script>
