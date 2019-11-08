$.fn.extend({
	showAlert: function(options) {
		return this.each(function() {
			$(this).append(`
      <div class="alert alert-${options.type} fade show" role="alert">
        ${options.body}
      </div>
      `);

			$(".alert").alert();

			var time = setTimeout(function() {
				$(".alert").alert("close");
				clearTimeout(time);
			}, 2500);
		});
	}
});
