$.fn.extend({
	Modal: function(options, callback) {
		return this.each(function() {
			/*
      options prop
      size: modal size => String { sm, md, lg }
      title: modal title => String,
      buttons: modal buttons => Array<String> || string,
      isCentered: modal position => Boolean,
      body: modal body => jQueryElement || String
      */

			//clone modal to reuse
			var modal = this
			var clone = $(this).clone(false);

			//listen to modal hidden event to remove modal from dom and append the cloned modal
			$(this).on("hidden.bs.modal", function(e) {
				$(this).remove();
				$("body").append(clone.clone(false));
			});

			//render modal structure
			$(this)
				.find(".modal-dialog")
				.addClass(options.size ? "modal-" + options.size : "modal-sm")
				.addClass(options.isCentered ? "modal-dialog-centered" : "");

			//render modal title
			$(this)
				.find(".modal-title")
				.html(options.title || "Modal Title");

			//render modal buttons
			if ($.isArray(options.buttons)) {
				options.buttons.forEach(function(button) {
					$(modal)
						.find(".modal-footer")
						.append(button);
				});
			} else {
				$(this).append(
					options.buttons ||
						"<button data-dismiss='modal' class='btn btn-primary'>Close</button>"
				);
			}

			//render modal content
			$(this)
				.find(".modal-body")
				.html(options.body);

			// do some async
			callback(this)
		});
	},
	createModal: function(options) {
		return this.each(function() {
			$(this).append(`
         <div class="modal fade" id="${options.id ||
						"jQueryModal"}" tabindex="-1" role="dialog" aria-labelledby="${options.id || "jQueryModal"}Title" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="${options.id ||
									"jQueryModal"}Title"></h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span>
                </button>
              </div>
              <div class="modal-body"></div>
              <div class="modal-footer d-flex flex-row justify-content-end"></div>
            </div>
          </div>
        </div>
      `);
		});
	},
	showAlert: function (options) {
		return this.each(function () {
			$(this).append(`
      <div class="alert alert-${options.type} fade show" role="alert">
        ${options.body}
      </div>
      `);

			$(".alert").alert();

			var time = setTimeout(function () {
				$(".alert").alert("close");
				clearTimeout(time);
			}, 2500);
		});
	}
});
