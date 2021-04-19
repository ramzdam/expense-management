$(document).ready(function() {
    $("#create-category").on('click', function(e) {
        e.preventDefault();
        var data = $(this).parents('form').serialize();
        
        $.ajax({
            method: "POST",
            url: "/expense/category",
            data: data,
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(res) {
                
                if (res.success) {
                    window.location.href = res.redirect;
                }
            }
        });
        
        return false;
    });

    $("#update-category").on('click', function(e) {
        e.preventDefault();
        var data = $(this).parents('form').serialize();
        var url = $(this).parents('form').attr('action');
        
        $.ajax({
            type: "PUT",
            url: url,
            data: data,
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(res) {
                
                if (res.success) {
                    window.location.href = res.redirect;
                }
            }
        });
        
        return false;
    });

    $(".delete-category").on('click', function(e) {
        e.preventDefault();
        var data = $(this).parents('form').serialize();
        var url = $(this).attr('href');
        
        $.ajax({
            type: "DELETE",
            url: url,
            data: data,
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(res) {
                if (res.success) {
                    window.location.href = res.redirect;
                }
            }
        });
        return false;
    });

    $("#create-expense").on('click', function(e) {
        e.preventDefault();
        var data = $(this).parents('form').serialize();
        var url = $(this).parents('form').attr('action');

        $.ajax({
            method: "POST",
            url: url,
            data: data,
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(res) {
                
                if (res.success) {
                    window.location.href = res.redirect;
                    
                }
            }
        });
        
        return false;
    });

    $("#update-expense").on('click', function(e) {
        e.preventDefault();
        var data = $(this).parents('form').serialize();
        var url = $(this).parents('form').attr('action');

        $.ajax({
            method: "PUT",
            url: url,
            data: data,
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(res) {
                
                if (res.success) {
                    window.location.href = res.redirect;
                    
                }
            }
        });
        
        return false;
    });

    $(".delete-expense").on('click', function(e) {
        e.preventDefault();
        var data = $(this).parents('form').serialize();
        var url = $(this).attr('href');
        
        $.ajax({
            type: "DELETE",
            url: url,
            data: data,
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(res) {
                if (res.success) {
                    window.location.href = res.redirect;
                }
            }
        });
        return false;
    });

    $("#create-user").on('click', function(e) {
        e.preventDefault();
        var data = $(this).parents('form').serialize();
        var url = $(this).parents('form').attr('action');

        $.ajax({
            method: "POST",
            url: url,
            data: data,
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(res) {
                
                if (res.success) {
                    window.location.href = res.redirect;
                    
                }
            }
        });
        
        return false;
    });

    $("#update-user").on('click', function(e) {
        e.preventDefault();
        var data = $(this).parents('form').serialize();
        var url = $(this).parents('form').attr('action');

        $.ajax({
            method: "PUT",
            url: url,
            data: data,
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(res) {
                
                if (res.success) {
                    window.location.href = res.redirect;
                    
                }
            }
        });
        
        return false;
    });

    $("#user-update-user").on('click', function(e) {
        e.preventDefault();
        var data = $(this).parents('form').serialize();
        var url = $(this).parents('form').attr('action');

        $.ajax({
            method: "PUT",
            url: url,
            data: data,
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(res) {
                
                if (res.success) {
                    window.location.href = res.redirect;
                    
                }
            }
        });
        
        return false;
    });

    $(".delete-user").on('click', function(e) {
        e.preventDefault();
        var data = $(this).parents('form').serialize();
        var url = $(this).attr('href');
        
        $.ajax({
            type: "DELETE",
            url: url,
            data: data,
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(res) {
                if (res.success) {
                    window.location.href = res.redirect;
                }
            }
        });
        return false;
    });

    if ($("#chartContainer").length) {
        var chart = new CanvasJS.Chart("chartContainer", {
            title: {
                text: "Total Expense Per Category"
            },
            axisY: {
                title: "Total Expense"
            },
            data: [{
                type: "column",	
                yValueFormatString: "PHP #,###",
                indexLabel: "{y}",
                dataPoints: []
            }]
        });

        $.ajax({
            type: "GET",
            url: "/chart",
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(res) {
                
                var dps = new Array();                
                res.data.forEach(function(data){
                    dps.push({label: data.label , y: parseInt(data.y)});
                });

                chart.options.data[0].dataPoints = dps; 
                chart.render();
            }
        });
    }    
});