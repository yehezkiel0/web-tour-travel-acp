import $ from "jquery";
$(function () {
    let itineraryCount = 0;

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
        $(".itinerary-item").each(function () {
            itineraryData.push({
                title: $(this)
                    .find('input[name^="itinerary["][name$="[title]"]')
                    .val(),
                day: $(this)
                    .find('input[name^="itinerary["][name$="[day]"]')
                    .val(),
                duration: $(this)
                    .find('input[name^="itinerary["][name$="[duration]"]')
                    .val(),
                description: $(this)
                    .find('textarea[name^="itinerary["][name$="[description]"]')
                    .val(),
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

    // Add initial itinerary item if we're on the correct page
    if ($("#addItinerary").length) {
        $("#addItinerary").trigger("click");
    }
});
