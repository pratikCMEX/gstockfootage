$(document).ready(function () {


  filterProducts();
  updateAllProductSrNo();
  toggleMoveButtons();


  function filterProducts() {

    let type = $('#filterProductType').val().toLowerCase();

    let searchAll = $('#searchAllProducts').val().toLowerCase();
    let searchPriority = $('#searchPriorityProducts').val().toLowerCase();

    // ALL PRODUCTS
    $('#all-products tr').each(function () {

      let rowType = $(this).find('td:eq(3)').text().toLowerCase().trim();
      let rowText = $(this).text().toLowerCase();

      if (rowType === type && rowText.includes(searchAll)) {
        $(this).show();
      } else {
        $(this).hide();
      }

    });

    // PRIORITY PRODUCTS
    $('#priority-products tr').each(function () {

      let rowType = $(this).find('td:eq(3)').text().toLowerCase().trim();
      let rowText = $(this).text().toLowerCase();

      if (rowType === type && rowText.includes(searchPriority)) {
        $(this).show();
      } else {
        $(this).hide();
      }

    });

  }

  function resetAllCheckboxes() {

    // Uncheck all row checkboxes
    $('#all-products input[name="selectPriority"]').prop('checked', false);
    $('#priority-products .priorityCheck').prop('checked', false);

    // Uncheck header checkboxes
    $('#allPriority').prop('checked', false);
    $('#allPrioritySelected').prop('checked', false);
  }
  $('#filterProductType').on('change', function () {
    filterProducts();
    updatePriorityNumbers();
    updateAllProductSrNo();
    toggleMoveButtons();

  });


  $('#searchAllProducts').on('keyup', function () {
    filterProducts();
    updateAllProductSrNo();
    toggleMoveButtons();
  });

  $('#searchPriorityProducts').on('keyup', function () {
    filterProducts();
    updatePriorityNumbers();
    toggleMoveButtons();
  });
  /* SEARCH PRIORITY PRODUCTS */


  $('#emptyPriorityList').click(function () {

    $('#priority-products tr:visible').each(function () {

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

    // 🔥 Remove only visible rows (not all)
    $('#priority-products tr:visible').remove();

    updatePriorityNumbers();
    updateAllProductSrNo();
    toggleMoveButtons();

    // reset checkboxes
    $('#allPrioritySelected').prop('checked', false);

  });


  function updatePriorityNumbers() {

    let imageCount = 1;
    let videoCount = 1;

    $('#priority-products tr').each(function () {

      let type = $(this).find('td:eq(3)').text().toLowerCase().trim();

      if (type === 'image') {
        $(this).find('.priority-number').text(imageCount++);
      } else if (type === 'video') {
        $(this).find('.priority-number').text(videoCount++);
      }

    });

  }

  function updateAllProductSrNo() {

    let count = 1;

    $('#all-products tr:visible').each(function () {
      $(this).find('td:eq(1)').text(count++);
    });

  }
  /* CHECKBOX LOGIC */

  $(document).on('change', '#allPriority', function () {
    $('#all-products tr:visible').find('input[name="selectPriority"]')
      .prop('checked', $(this).prop('checked'));
    toggleMoveButtons();
  });

  $(document).on('change', '#allPrioritySelected', function () {
    $('#priority-products tr:visible').find('.priorityCheck')
      .prop('checked', $(this).prop('checked'));
    toggleMoveButtons();
  });

  $(document).on('change', '.priorityCheck', function () {

    // let total = $('.priorityCheck').length;
    // let checked = $('.priorityCheck:checked').length;

    // $('#allPrioritySelected').prop('checked', total === checked);

    let total = $('#priority-products tr:visible .priorityCheck').length;
    let checked = $('#priority-products tr:visible .priorityCheck:checked').length;

    $('#allPrioritySelected').prop('checked', total > 0 && total === checked);
    toggleMoveButtons();

  });


  $(document).on('change', 'input[name="selectPriority"]', function () {

    let total = $('#all-products tr:visible')
      .find('input[name="selectPriority"]').length;

    let checked = $('#all-products tr:visible')
      .find('input[name="selectPriority"]:checked').length;

    // $('#allPriority').prop('checked', total === checked);
    $('#allPriority').prop('checked', total > 0 && total === checked);
    toggleMoveButtons();
  });


  $(document).on('change', '.priorityCheck', function () {

    let total = $('#priority-products tr:visible').find('.priorityCheck').length;
    let checked = $('#priority-products tr:visible').find('.priorityCheck:checked').length;

    $('#allPriority').prop('checked', total > 0 && total === checked);
    // $('#allPrioritySelected').prop('checked', total === checked);

    toggleMoveButtons();
  });


  function toggleMoveButtons() {

    let selectedAllProducts = $('#all-products tr:visible')
      .find('input[name="selectPriority"]:checked').length;

    let selectedPriority = $('#priority-products tr:visible')
      .find('.priorityCheck:checked').length;

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

  function updateHeaderCheckboxes() {

    // ALL PRODUCTS
    let totalAll = $('#all-products tr:visible input[name="selectPriority"]').length;
    let checkedAll = $('#all-products tr:visible input[name="selectPriority"]:checked').length;

    $('#allPriority').prop('checked', totalAll > 0 && totalAll === checkedAll);

    // PRIORITY PRODUCTS
    let totalPriority = $('#priority-products tr:visible .priorityCheck').length;
    let checkedPriority = $('#priority-products tr:visible .priorityCheck:checked').length;

    $('#allPrioritySelected').prop('checked', totalPriority > 0 && totalPriority === checkedPriority);
  }

  /* MOVE TO PRIORITY BUTTON */

  $('#MoveToPriority').click(function () {

    $('#all-products tr:visible').find('input[name="selectPriority"]:checked').each(function () {

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

    $('#allPriority').prop('checked', false);
  });

  /* MOVE TO ALL PRODUCTS */


  $('#MoveToAllProducts').click(function () {

    $('#priority-products tr:visible').find('.priorityCheck:checked').each(function () {

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

    $('#allPrioritySelected').prop('checked', false);
  });
  /* DRAG & DROP */

  new Sortable(document.getElementById('all-products'), {
    group: 'products',
    animation: 150,
    handle: "td:nth-child(n+3)",
    filter: "input[type='checkbox']",   // prevent drag from checkbox
    preventOnFilter: false,
    onAdd: function (evt) {

      let draggedRow = evt.item;
      let id = $(draggedRow).data('id');

      let name = $(draggedRow).find('td:eq(2)').html();
      let type = $(draggedRow).find('td:eq(3)').html();
      let preview = $(draggedRow).find('td:eq(4)').html();
      let price = $(draggedRow).find('td:eq(5)').html();



      // CREATE fresh row (unchecked by default)
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

      let rows = $('#all-products tr');

      if (rows.length === 0 || evt.newIndex >= rows.length) {
        $('#all-products').append(newRow);
      } else {
        $(rows[evt.newIndex]).before(newRow);
      }
      // REMOVE old row completely

      $(draggedRow).remove();

      updatePriorityNumbers();
      updateAllProductSrNo();
      updateHeaderCheckboxes();
      syncCheckboxState('#all-products', '#allPriority', 'input[name="selectPriority"]');
      // resetAllCheckboxes();   // 🔥 important
      toggleMoveButtons();
    },
    onEnd: function () {
      updatePriorityNumbers();
      updateAllProductSrNo();
      updateHeaderCheckboxes();
      syncCheckboxState('#all-products', '#allPriority', 'input[name="selectPriority"]');
      // resetAllCheckboxes();   // ✅ ADD
      toggleMoveButtons();
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
      let rows = $('#priority-products tr');

      if (rows.length === 0 || evt.newIndex >= rows.length) {
        $('#priority-products').append(newRow);
      } else {
        $(rows[evt.newIndex]).before(newRow);
      }
      $(draggedRow).remove();
      updatePriorityNumbers();
      updateAllProductSrNo();
      updateHeaderCheckboxes();
      syncCheckboxState('#priority-products', '#allPrioritySelected', '.priorityCheck');
      // resetAllCheckboxes();
      toggleMoveButtons();
    },

    onEnd: function () {
      updatePriorityNumbers();
      updateAllProductSrNo();
      updateHeaderCheckboxes();
      syncCheckboxState('#priority-products', '#allPrioritySelected', '.priorityCheck');
      // resetAllCheckboxes();
      toggleMoveButtons();
    }

  });

  function syncCheckboxState(container, headerCheckbox, rowCheckbox) {

    let isHeaderChecked = $(headerCheckbox).prop('checked');

    if (isHeaderChecked) {
      $(container).find(rowCheckbox).prop('checked', true);
    }

  }
  /* SAVE PRIORITY */

  $('#savePriority').click(function () {

    let imageOrder = [];
    let videoOrder = [];

    $('#priority-products tr').each(function () {

      let id = $(this).data('id');
      let type = $(this).find('td:eq(3)').text().toLowerCase().trim();

      if (type === 'image') {
        imageOrder.push(id);
      } else if (type === 'video') {
        videoOrder.push(id);
      }

    });

    $.ajax({
      url: "/admin/product/update-priority",
      method: "POST",
      data: {
        imageOrder: imageOrder,
        videoOrder: videoOrder,
        _token: $('meta[name="csrf-token"]').attr('content')
      },
      success: function () {
        toastr.success("Priority Saved Successfully");
      }
    });

  });
  // $('#savePriority').click(function () {

  //   let order = [];

  //   $('#priority-products tr').each(function () {

  //     order.push($(this).data('id'));

  //   });

  //   $.ajax({

  //     url: "/admin/product/update-priority",
  //     method: "POST",

  //     data: {
  //       order: order,
  //       _token: $('meta[name="csrf-token"]').attr('content')
  //     },

  //     success: function () {

  //       toastr.success("Priority Saved Successfully");

  //     }

  //   });

  // });


});