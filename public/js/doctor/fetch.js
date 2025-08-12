$(function () {
    const doctorDropdown = $('#doctor');
    const departmentDropdown = $('#department');
    const departmentId = departmentDropdown.val();
    const selectedDoctorId = doctorDropdown.data('old-value');

    function fetchDoctors(departmentId, selectedDoctorId = null) {
        doctorDropdown.empty().append(`<option value="">Select Doctor</option>`);

        if (departmentId) {
            $.ajax({
                url: '/doctor/department/' + departmentId,
                method: 'GET',
                dataType: 'json',
                success: function (response) {
                    let doctors = response.doctors;
                    doctorDropdown.prop('disabled', false);

                    $.each(doctors, function (index, doctor) {
                        let selected = selectedDoctorId && doctor.id === selectedDoctorId ? 'selected' : '';
                        doctorDropdown.append(`<option value="${doctor.id}" ${selected}>${doctor.name}</option>`);
                    });
                },
                error: function (jqXHR) {
                    console.log(jqXHR)
                    doctorDropdown.prop('disabled', true);
                }
            });
        } else {
            doctorDropdown.prop('disabled', true);
        }
    }

    departmentDropdown.on('change', function () {
        const departmentId = $(this).val();
        fetchDoctors(departmentId);
    });

    if (departmentId) {
        fetchDoctors(departmentId, selectedDoctorId);
    }
});
