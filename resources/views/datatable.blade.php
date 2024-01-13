<script>
    var datatable;
    $(function() {
        datatable = $('#blogTable').DataTable({
            pageLength: 10,
            processing: true,
            serverSide: true,
            responsive: false,
            'columnDefs': [
                {
                    targets: [4],
                    render: function(data, type, row) {
                        console.log(data);
                       return `<img src="images1/${data}" style="width:200px;">`;
                    }
                },
                {
                    targets: [7],
                    render: function(data, type, row) {
                        var editAction =
                            `<a href="javascript:void(0);" class="btn btn-sm text-primary fa-tip"  title="Edit" onclick="editBlog(${data})" ><i class="fa fa-pen cursor-pointer f-size-14"></i></a>`;
                        var deleteAction =
                            `<a href="javascript:void(0);" class="btn btn-sm text-danger fa-tip"  title="Delete" onclick="deleteBlog(${data})"><i class="fa fa-trash cursor-pointer f-size-14"></i></a>`;

                        return '<div class="d-flex">' + editAction + deleteAction + '</div>';

                    },
                }
            ],
            dom: 'Blrtip',
            ajax: {
                url: '{{ route('blog.getData') }}',
                type: "get",
                data: function(d) {

                }
            },
            "order": [
                [0, "desc"]
            ],
            "paging": true,
            columns: [
                {
                    data: 'DT_RowIndex',
                    name: "id",
                    orderable:false
                },
                {
                    data: 'name',
                    name: "name"
                },
                {
                    data: 'date',
                    name: "date"
                },
                {
                    data: 'author',
                    name: "author"
                },
                {
                    data: 'image',
                    name: "image"
                },
                {
                    data: 'content',
                    name: "content"
                },

                {
                    data: 'updated_at',
                    name: "updated_at"
                },
                {
                    data: 'id',
                    name: 'id',
                    orderable:false
                }
            ],
            "initComplete": function() {
                var i = 0;
                var input_text = [1, 2, 3, 4, 5, 6];
                var non_searchable = [0];
                this.api().columns().every(function() {
                    var column = this;
                   if (i == 6 || i==2) {
                        var input =
                            `<input type="date" name="date" class="per-page form-control form-control-sm m-input">`;
                        $(input).appendTo($(column.footer()).empty()).on('change',
                            function() {
                                column.search($(this).val(), false, false, true).draw();
                            });
                    } else if (non_searchable.includes(i)) {
                        var input = ``
                        $(input).appendTo($(column.footer()).empty())
                            .on('change', function() {

                            });
                    } else if (input_text.includes(i)) {
                        var input =
                            "<input type='text'  placeholder=\"&#xF002; Search\" style='height:30px; font-family: Arial,FontAwesome' class=\"per-page form-control form-control-sm m-input\">";
                        $(input).appendTo($(column.footer()).empty())
                            .on('change', function() {
                                column.search($(this).val(), false, false, true).draw();
                            });
                    }
                    i++;
                });
            },
        });
    });
</script>
