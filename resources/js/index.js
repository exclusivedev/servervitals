// $.ajaxSetup({
//   headers: {
//     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//   }
// });

window.Visibility = require('visibilityjs');

window.Echo.channel('live-monitor')
.listen('.finished.check', (e) => {

  const { id, type, last_run_message, element_class, last_update, host_id } = e.message;
  
  let element = document.querySelector(`#${id} .${type}`);
  element.textContent = last_run_message;
  element.classList.remove('text-success text-danger text-warning');
  element.classList.add(element_class);

  element = document.querySelector(`#${host_id}`);
  element.textContent = `Last update: ${last_update}`;
  // $(`#${id} .${type}`)
  //   .text(last_run_message)
  //   .removeClass('text-success text-danger text-warning')
  //   .addClass(element_class);

  // $(`#${host_id}`).text(`Last update: ${last_update}`);
});


Visibility.change(function (e, state) {
  axios.post('/page-visibility', { state });
});