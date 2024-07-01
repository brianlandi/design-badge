document.addEventListener("DOMContentLoaded", function () {
  // Handle design tool selection
  document
    .getElementById("db_select_field_design_tool")
    .addEventListener("change", function (e) {
      const customFieldWrapper = document.querySelector(
        ".custom-image-wrapper"
      );
      if (e.target.value === "custom") {
        customFieldWrapper.style.display = "block";
      } else {
        customFieldWrapper.style.display = "none";
      }
    });

  // Media uploader
  let mediaUploader;
  document
    .getElementById("upload_image_button")
    .addEventListener("click", function (e) {
      e.preventDefault();
      if (mediaUploader) {
        mediaUploader.open();
        return;
      }
      mediaUploader = wp.media({
        title: "Select Image",
        button: {
          text: "Use this image",
        },
        multiple: false,
      });

      mediaUploader.on("select", function () {
        const attachment = mediaUploader
          .state()
          .get("selection")
          .first()
          .toJSON();
        document.getElementById("db_image_field").value = attachment.url;
        document.getElementById("db_image_preview").innerHTML =
          '<img src="' +
          attachment.url +
          '" style="max-width: 300px;" />' +
          '<input type="button" id="remove_image_button" class="button" value="Remove Image" />';
        attachRemoveImageListener();
      });

      mediaUploader.open();
    });

  function attachRemoveImageListener() {
    document
      .getElementById("remove_image_button")
      .addEventListener("click", function () {
        document.getElementById("db_image_field").value = "";
        document.getElementById("db_image_preview").innerHTML = "";
      });
  }

  if (document.getElementById("remove_image_button")) {
    attachRemoveImageListener();
  }
});
