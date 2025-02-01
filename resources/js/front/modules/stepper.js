export const initStepper = ($) => {
    $(document).ready(function () {
        const steps = ["Select Tour", "Contact Details", "Payment", "Complete"];

        // Ambil nilai currentStep dari atribut data
        const stepperElement = document.getElementById("stepper");

        if (stepperElement === null) return;

        let currentStep = parseInt(
            stepperElement.getAttribute("data-current-step")
        );

        function updateStepperUI() {
            $(".step-circle").each(function () {
                const step = $(this).data("step");
                const isLastStep = currentStep === steps.length;

                $(this)
                    .toggleClass("active", step === currentStep && !isLastStep)
                    .toggleClass("completed", step < currentStep || isLastStep);

                $(".step-active-indicator", this).toggleClass(
                    "hidden",
                    step !== currentStep
                );
            });

            $(".step-label, .step-line").each(function () {
                $(this).toggleClass(
                    "completed",
                    $(this).data("step") < currentStep
                );
            });

            // $(".step-content")
            //     .hide()
            //     .filter(`[data-step="${currentStep}"]`)
            //     .show();
            // $(".step-title").text(steps[currentStep - 1]);
            // $(".current-step").text(currentStep);

            $(".prev-step").prop("disabled", currentStep === 1);
            $(".next-step")
                .prop("disabled", currentStep === steps.length)
                .text(currentStep === steps.length ? "Complete" : "Next");
        }

        // Jika masih menggunakan tombol next/prev (opsional)
        $(".next-step, .prev-step").click(function () {
            currentStep += $(this).hasClass("next-step") ? 1 : -1;
            updateStepperUI();
        });

        // Update UI stepper saat halaman dimuat
        updateStepperUI();
    });
};
