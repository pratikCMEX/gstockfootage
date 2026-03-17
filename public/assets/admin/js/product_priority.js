$(document).ready(function () {

  /* SEARCH ALL PRODUCTS */

  $('#searchAllProducts').on('keyup', function () {

    let value = $(this).val().toLowerCase();

    $('#all-products tr').filter(function () {

      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);

    });

  });


  /* SEARCH PRIORITY PRODUCTS */

  $('#searchPriorityProducts').on('keyup', function () {

    let value = $(this).val().toLowerCase();

    $('#priority-products tr').filter(function () {

      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);

    });

  });


  $('#emptyPriorityList').click(function () {

    $('#priority-products tr').each(function () {

      let row = $(this);
      let id = row.data('id');

      let name = row.find('td:eq(2)').html();
      let type = row.find('td:eq(3)').html();
      let preview = row.find('td:eq(4)').html();
      let price = row.find('td:eq(5)').html();

      let newRow = `
<tr data-id="${id}">
<td><input type="checkbox" name="selectPriority" value="${id}"></td>
<td></td>
<td>${name}</td>
<td>${type}</td>
<td>${preview}</td>
<td>${price}</td>
</tr>
`;

      $('#all-products').append(newRow);

    });

    // clear priority table
    $('#priority-products').empty();

    updateAllProductSrNo();
    toggleMoveButtons();

  });
  function updatePriorityNumbers() {

    $('#priority-products tr').each(function (index) {
      $(this).find('.priority-number').text(index + 1);
    });

  }
  function updateAllProductSrNo() {

    $('#all-products tr').each(function (index) {
      $(this).find('td:eq(1)').text(index + 1);
    });

  }

  updateAllProductSrNo();
  /* CHECKBOX LOGIC */

  $(document).on('change', '#allPriority', function () {
    $('input[name="selectPriority"]').prop('checked', $(this).prop('checked'));
    toggleMoveButtons();
  });
  /* PRIORITY SELECT ALL */

  $(document).on('change', '#allPrioritySelected', function () {

    $('.priorityCheck').prop('checked', $(this).prop('checked'));

    toggleMoveButtons();

  });
  $(document).on('change', '.priorityCheck', function () {

    let total = $('.priorityCheck').length;
    let checked = $('.priorityCheck:checked').length;

    $('#allPrioritySelected').prop('checked', total === checked);

    toggleMoveButtons();

  });

  $(document).on('change', 'input[name="selectPriority"]', function () {
   let total = $('input[name="selectPriority"]').length;
    let checked = $('input[name="selectPriority"]:checked').length;

    if (total === checked) {
        $('#allPriority').prop('checked', true);
    } else {
        $('#allPriority').prop('checked', false);
    }
    toggleMoveButtons();
  });

  $(document).on('change', '.priorityCheck', function () {
    toggleMoveButtons();
  });


  function toggleMoveButtons() {

    let selectedAllProducts = $('input[name="selectPriority"]:checked').length;
    let selectedPriority = $('.priorityCheck:checked').length;

    if (selectedAllProducts > 0) {
      $('#MoveToPriority').removeClass('d-none');
    } else {
      $('#MoveToPriority').addClass('d-none');
    }

    if (selectedPriority > 0) {
      $('#MoveToAllProducts').removeClass('d-none');
    } else {
      $('#MoveToAllProducts').addClass('d-none');
    }

  }


  /* MOVE TO PRIORITY BUTTON */

  $('#MoveToPriority').click(function () {

    $('input[name="selectPriority"]:checked').each(function () {

      let row = $(this).closest('tr');

      let name = row.find('td:eq(2)').html();
      let type = row.find('td:eq(3)').html();
      let preview = row.find('td:eq(4)').html();
      let price = row.find('td:eq(5)').html();
      let id = row.data('id');

      let newRow = `
<tr data-id="${id}">
<td><input type="checkbox" class="priorityCheck"></td>
<td class="priority-number"></td>
<td>${name}</td>
<td>${type}</td>
<td>${preview}</td>
<td>${price}</td>
</tr>
`;

      $('#priority-products').append(newRow);

      row.remove();

    });

    updatePriorityNumbers();
    updateAllProductSrNo();
    toggleMoveButtons();

    // reset checkboxes
    $('#allPriority').prop('checked', false);
    $('input[name="selectPriority"]').prop('checked', false);

  });


  /* MOVE TO ALL PRODUCTS */

  $('#MoveToAllProducts').click(function () {

    $('.priorityCheck:checked').each(function () {

      let row = $(this).closest('tr');

      let id = row.data('id');

      let name = row.find('td:eq(2)').html();
      let type = row.find('td:eq(3)').html();
      let preview = row.find('td:eq(4)').html();
      let price = row.find('td:eq(5)').html();

      let newRow = `
<tr data-id="${id}">
<td><input type="checkbox" name="selectPriority" value="${id}"></td>
<td></td>
<td>${name}</td>
<td>${type}</td>
<td>${preview}</td>
<td>${price}</td>
</tr>
`;

      $('#all-products').append(newRow);

      row.remove();

    });

    updatePriorityNumbers();
    updateAllProductSrNo();
    toggleMoveButtons();
    // reset priority checkboxes
$('#allPrioritySelected').prop('checked', false);
$('.priorityCheck').prop('checked', false);

  });


  /* DRAG & DROP */

  new Sortable(document.getElementById('all-products'), {
    group: 'products',
    animation: 150,
    handle: "td:nth-child(n+3)",
    filter: "input[type='checkbox']",   // prevent drag from checkbox
    preventOnFilter: false,
    onEnd: function () {
      updatePriorityNumbers();
      updateAllProductSrNo();
    }
  });


  new Sortable(document.getElementById('priority-products'), {
    group: 'products',
    animation: 150,

    filter: "input[type='checkbox']",   // prevent drag from checkbox
    preventOnFilter: false,
    onAdd: function (evt) {

      let draggedRow = evt.item;
      let id = $(draggedRow).data('id');

      // get only required fields
      let name = $(draggedRow).find('td:eq(2)').html();
      let type = $(draggedRow).find('td:eq(3)').html();
      let preview = $(draggedRow).find('td:eq(4)').html();
      let price = $(draggedRow).find('td:eq(5)').html();

      // remove dragged row completely
      $(draggedRow).remove();

      // build correct priority row
      let newRow = `
<tr data-id="${id}">
<td><input type="checkbox" class="priorityCheck" value="${id}"></td>
<td class="priority-number"></td>
<td>${name}</td>
<td>${type}</td>
<td>${preview}</td>
<td>${price}</td>
</tr>
`;

      // append to priority table
      $('#priority-products').append(newRow);

      updatePriorityNumbers();
      updateAllProductSrNo();
    },

    onEnd: function () {
      updatePriorityNumbers();
      updateAllProductSrNo();
    }

  });


  /* SAVE PRIORITY */

  $('#savePriority').click(function () {

    let order = [];

    $('#priority-products tr').each(function () {

      order.push($(this).data('id'));

    });

    $.ajax({

      url: "/admin/product/update-priority",
      method: "POST",

      data: {
        order: order,
        _token: $('meta[name="csrf-token"]').attr('content')
      },

      success: function () {

        toastr.success("Priority Saved Successfully");

      }

    });

  });


});