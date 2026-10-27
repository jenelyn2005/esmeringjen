<?php
require_once 'connection.php';
require_once 'classes/Participants.php';
require_once 'includes/auth.php';
requireAuth();

$participant = new Participant($conn);
$participants = $participant->getAllParticipants();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Participants</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
          rel="stylesheet">
    <link href="assets/app.css" rel="stylesheet">

</head>

<body>

<div class="app-shell">

    <?php include 'includes/navigation.php'; ?>

    <header class="mb-4">
        <div class="page-kicker">People</div>
        <h1 class="page-title display-6 fw-bold mb-2">Participants</h1>
        <p class="text-secondary mb-0">Manage the people registered for your events.</p>
    </header>

    <!-- ============================= -->
    <!-- ADD PARTICIPANT BUTTON -->
    <!-- ============================= -->

    <div class="d-flex justify-content-end mb-3">

        <button type="button"
                class="btn btn-primary"
                data-bs-toggle="modal"
                data-bs-target="#addParticipant">

            Add Participant

        </button>

    </div>


    <!-- ============================= -->
    <!-- PARTICIPANTS TABLE -->
    <!-- ============================= -->

    <section class="table-panel">
    <div class="table-responsive">
    <table class="table align-middle">

        <thead>

        <tr>
            <th scope="col">#ID</th>
            <th scope="col">First Name</th>
            <th scope="col">Last Name</th>
            <th scope="col">Email</th>
            <th scope="col">Gender</th>
            <th scope="col">Birthdate</th>
            <th scope="col">City</th>
            <th scope="col">Action</th>
        </tr>

        </thead>

        <tbody>

        <?php foreach ($participants as $item): ?>

            <tr>

                <!-- ID -->
                <th scope="row">
                    <?php echo htmlspecialchars($item->participants_id); ?>
                </th>

                <!-- First Name -->
                <td>
                    <?php echo htmlspecialchars($item->first_name); ?>
                </td>

                <!-- Last Name -->
                <td>
                    <?php echo htmlspecialchars($item->last_name); ?>
                </td>

                <!-- Email -->
                <td>
                    <?php echo htmlspecialchars($item->email); ?>
                </td>

                <!-- Gender -->
                <td>
                    <?php echo htmlspecialchars($item->gender); ?>
                </td>

                <!-- Birthdate -->
                <td>
                    <?php echo htmlspecialchars($item->birthdate); ?>
                </td>

                <!-- City -->
                <td>
                    <?php echo htmlspecialchars($item->city); ?>
                </td>

                <!-- ACTION -->
                <td>

                    <!-- ============================= -->
                    <!-- UPDATE BUTTON -->
                    <!-- ============================= -->

                    <button type="button"
                            class="btn btn-warning btn-sm"

                            data-bs-toggle="modal"
                            data-bs-target="#updateParticipant"

                            data-id="<?php echo htmlspecialchars($item->participants_id, ENT_QUOTES); ?>"
                            data-firstname="<?php echo htmlspecialchars($item->first_name, ENT_QUOTES); ?>"
                            data-lastname="<?php echo htmlspecialchars($item->last_name, ENT_QUOTES); ?>"
                            data-email="<?php echo htmlspecialchars($item->email, ENT_QUOTES); ?>"
                            data-gender="<?php echo htmlspecialchars($item->gender, ENT_QUOTES); ?>"
                            data-birthdate="<?php echo htmlspecialchars($item->birthdate, ENT_QUOTES); ?>"
                            data-city="<?php echo htmlspecialchars($item->city, ENT_QUOTES); ?>"

                            onclick="setUpdateData(this)">

                        Update

                    </button>


                    <!-- ============================= -->
                    <!-- DELETE BUTTON -->
                    <!-- ============================= -->

                    <button type="button"
                            class="btn btn-danger btn-sm"

                            data-bs-toggle="modal"
                            data-bs-target="#deleteParticipant"

                            data-id="<?php echo htmlspecialchars($item->participants_id, ENT_QUOTES); ?>"
                            data-name="<?php echo htmlspecialchars($item->first_name . ' ' . $item->last_name, ENT_QUOTES); ?>"

                            onclick="setDeleteData(this)">

                        Delete

                    </button>

                </td>

            </tr>

        <?php endforeach; ?>

        </tbody>

    </table>
    </div>
    </section>


    <!-- ============================= -->
    <!-- ADD PARTICIPANT MODAL -->
    <!-- ============================= -->

    <?php include 'modals/addParticipant.php'; ?>


    <!-- ============================= -->
    <!-- UPDATE PARTICIPANT MODAL -->
    <!-- ============================= -->

    <div class="modal fade"
         id="updateParticipant"
         tabindex="-1"
         aria-labelledby="updateParticipantLabel"
         aria-hidden="true">

        <div class="modal-dialog">

            <div class="modal-content">

                <!-- HEADER -->

                <div class="modal-header">

                    <h5 class="modal-title"
                        id="updateParticipantLabel">

                        Update Participant

                    </h5>

                    <button type="button"
                            class="btn-close"
                            data-bs-dismiss="modal">
                    </button>

                </div>


                <!-- FORM -->

                <form action="backend/participant_code.php"
                      method="POST">

                    <div class="modal-body">

                        <!-- PARTICIPANT ID -->

                        <input type="hidden"
                               name="participants_id"
                               id="update_participant_id">


                        <!-- FIRST NAME -->

                        <div class="mb-3">

                            <label class="form-label">
                                First Name
                            </label>

                            <input type="text"
                                   class="form-control"
                                   name="first_name"
                                   id="update_first_name"
                                   required>

                        </div>


                        <!-- LAST NAME -->

                        <div class="mb-3">

                            <label class="form-label">
                                Last Name
                            </label>

                            <input type="text"
                                   class="form-control"
                                   name="last_name"
                                   id="update_last_name"
                                   required>

                        </div>


                        <!-- EMAIL -->

                        <div class="mb-3">

                            <label class="form-label">
                                Email
                            </label>

                            <input type="email"
                                   class="form-control"
                                   name="email"
                                   id="update_email"
                                   required>

                        </div>


                        <!-- GENDER -->

                        <div class="mb-3">

                            <label class="form-label">
                                Gender
                            </label>

                            <input type="text"
                                   class="form-control"
                                   name="gender"
                                   id="update_gender"
                                   required>

                        </div>


                        <!-- BIRTHDATE -->

                        <div class="mb-3">

                            <label class="form-label">
                                Birthdate
                            </label>

                            <input type="date"
                                   class="form-control"
                                   name="birthdate"
                                   id="update_birthdate"
                                   required>

                        </div>


                        <!-- CITY -->

                        <div class="mb-3">

                            <label class="form-label">
                                City
                            </label>

                            <input type="text"
                                   class="form-control"
                                   name="city"
                                   id="update_city"
                                   required>

                        </div>

                    </div>


                    <!-- FOOTER -->

                    <div class="modal-footer">

                        <button type="button"
                                class="btn btn-secondary"
                                data-bs-dismiss="modal">

                            Cancel

                        </button>

                        <button type="submit"
                                class="btn btn-warning"
                                name="update_participant">

                            Update Participant

                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>


    <!-- ============================= -->
    <!-- DELETE PARTICIPANT MODAL -->
    <!-- ============================= -->

    <div class="modal fade"
         id="deleteParticipant"
         tabindex="-1"
         aria-labelledby="deleteParticipantLabel"
         aria-hidden="true">

        <div class="modal-dialog">

            <div class="modal-content">

                <!-- HEADER -->

                <div class="modal-header">

                    <h5 class="modal-title"
                        id="deleteParticipantLabel">

                        Delete Participant

                    </h5>

                    <button type="button"
                            class="btn-close"
                            data-bs-dismiss="modal">
                    </button>

                </div>


                <!-- DELETE FORM -->

                <form action="backend/participant_code.php"
                      method="POST">

                    <div class="modal-body">

                        <!-- PARTICIPANT ID -->

                        <input type="hidden"
                               name="participants_id"
                               id="delete_participant_id">


                        <!-- CONFIRMATION MESSAGE -->

                        <p>
                            Are you sure you want to delete
                            <strong id="delete_participant_name"></strong>?
                        </p>

                    </div>


                    <!-- FOOTER -->

                    <div class="modal-footer">

                        <button type="button"
                                class="btn btn-secondary"
                                data-bs-dismiss="modal">

                            Cancel

                        </button>

                        <button type="submit"
                                class="btn btn-danger"
                                name="delete_participant">

                            Delete Participant

                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

</div>


<!-- ============================= -->
<!-- JAVASCRIPT -->
<!-- ============================= -->

<script>

    // ==================================
    // SET UPDATE DATA
    // ==================================

    function setUpdateData(button) {

        document.getElementById("update_participant_id").value =
            button.getAttribute("data-id");

        document.getElementById("update_first_name").value =
            button.getAttribute("data-firstname");

        document.getElementById("update_last_name").value =
            button.getAttribute("data-lastname");

        document.getElementById("update_email").value =
            button.getAttribute("data-email");

        document.getElementById("update_gender").value =
            button.getAttribute("data-gender");

        document.getElementById("update_birthdate").value =
            button.getAttribute("data-birthdate");

        document.getElementById("update_city").value =
            button.getAttribute("data-city");
    }


    // ==================================
    // SET DELETE DATA
    // ==================================

    function setDeleteData(button) {

        const id = button.getAttribute("data-id");

        const name = button.getAttribute("data-name");


        document.getElementById("delete_participant_id").value =
            id;


        document.getElementById("delete_participant_name").textContent =
            name;
    }

</script>


<!-- Bootstrap JavaScript -->

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js">
</script>


</body>
</html>