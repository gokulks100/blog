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
                    targets: [9],
                    render: function(data, type, row) {
                        if (data == 1) {
                            return `<a href="#" onclick="statusChange(${row.id},0)"><span class= "badge badge-success">Active</span></a>`;
                        } else {
                            return `<a href="#" onclick="statusChange(${row.id},1)"><span class= "badge badge-danger">In Active</span></a>`;
                        }
                    }
                },
                {
                    targets: [10],
                    render: function(data, type, row) {

                        if (row.action.includes('edit')) {
                            var editAction =
                                `<a href="javascript:void(0);" class="btn btn-sm text-primary fa-tip"  title="Edit" onclick="editService(${data})" ><i class="fa fa-pen cursor-pointer f-size-14"></i></a>`;
                        }

                        if (row.action.includes('delete')) {
                            var deleteAction =
                                `<a href="javascript:void(0);" class="btn btn-sm text-danger fa-tip"  title="Delete" onclick="deleteService(${data})"><i class="fa fa-trash cursor-pointer f-size-14"></i></a>`;
                        }

                        return '<div class="d-flex">' + editAction + deleteAction + '</div>';


                        // <a  href="javascript:void(0);" class="btn btn-sm text-dark mr-1 fa-tip"  title="View Privileges" data-toggle="modal" onclick="viewUser(${data})" ><i class="fa fa-eye cursor-pointer f-size-14"></i></a>
                        return `<div class="d-flex">


                                </div>`;
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
            columns: [{
                    data: 'DT_RowIndex',
                    name: "id",
                    orderable:false
                },
                {
                    data: 'name',
                    name: "name"
                },
                {
                    data: 'min_members',
                    name: "min_members"
                },
                {
                    data: 'max_members',
                    name: "max_members"
                },
                {
                    data: 'price',
                    name: "price"
                },
                {
                    data: 'tax',
                    name: "tax"
                },
                {
                    data: 'description',
                    name: "description"
                },
                {
                    data: 'updated_by',
                    name: "updated_by"
                },
                {
                    data: 'updated_at',
                    name: "updated_at"
                },
                {
                    data: 'is_active',
                    name: "is_active"
                },
                {
                    data: 'id',
                    name: 'id',
                    orderable:false
                }
            ],
            "initComplete": function() {
                var i = 0;
                var input_text = [1, 2, 3, 4, 5, 6, 7, 8];
                var non_searchable = [0];
                this.api().columns().every(function() {
                    var column = this;
                    if (i == 9) {
                        var input = `<select  id="value_type" style='height:30px; font-family: Arial,FontAwesome' class="per-page form-control form-control-sm m-input">
                                       <option value="">All</option>
                                       <option value="1">Active</option>
                                       <option value="0">InActive</option>
                                   </select>`;
                        $(input).appendTo($(column.footer()).empty()).on('change',
                            function() {
                                column.search($(this).val(), false, false, true).draw();
                            });
                    } else if (i == 8) {
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
