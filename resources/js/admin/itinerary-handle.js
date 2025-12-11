// jQuery is already available globally from bootstrap.js
$(function () {
    let itineraryCount = $("#itineraryContainer .itinerary-item").length || 0;

    // Add new itinerary item
    $("#addItinerary").on("click", function () {
        const template = document.querySelector("#itineraryTemplate");
        if (template) {
            const clone = template.content.cloneNode(true);

            // Update the indices
            $(clone)
                .find("input, textarea")
                .each(function () {
                    const name = $(this).attr("name");
                    if (name) {
                        $(this).attr(
                            "name",
                            name.replace("[0]", `[${itineraryCount}]`)
                        );
                    }
                });

            // Set the day number
            const dayInput = $(clone).find('input[type="number"]');
            if (dayInput.length) {
                dayInput.val(itineraryCount + 1);
            }

            $("#itineraryContainer").append(clone);
            itineraryCount++;
        }
    });

    // Remove itinerary item
    $(document).on("click", ".remove-itinerary", function () {
        $(this).closest(".itinerary-item").remove();
    });

    // Form submission
    $("#detailsForm").on("submit", function (e) {
        e.preventDefault();

        // Collect itinerary data
        const itineraryData = [];
        $(".itinerary-item").each(function (index) {
            const day = $(this).find('input[name*="[day]"]').val() || index + 1;
            const title = $(this).find('input[name*="[title]"]').val();
            const duration = $(this).find('input[name*="[duration]"]').val();
            const alternative = $(this)
                .find('input[name*="[alternative]"]')
                .val();
            const description = $(this)
                .find('textarea[name*="[description]"]')
                .val();

            itineraryData.push({
                day: parseInt(day),
                title: title,
                duration: duration,
                alternative: alternative,
                description: description,
            });
        });

        // Add itinerary data as JSON
        const itineraryInput = $("<input>")
            .attr("type", "hidden")
            .attr("name", "itinerary")
            .val(JSON.stringify(itineraryData));
        $(this).append(itineraryInput);

        // Submit the form
        this.submit();
    });

    // Add initial itinerary item if we're on the correct page and no items exist
    if ($("#addItinerary").length && itineraryCount === 0) {
        $("#addItinerary").trigger("click");
    }
});
