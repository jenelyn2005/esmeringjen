<!-- Delete Participant Modal -->
<div class="modal fade"
     id="deleteParticipant"
     tabindex="-1"
     aria-labelledby="deleteParticipantLabel"
     aria-hidden="true">

    <div class="modal-dialog">

        <div class="modal-content">

            <!-- Header -->
            <div class="modal-header">

                <h5 class="modal-title" id="deleteParticipantLabel">
                    Delete Participant
                </h5>

                <button type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"s
                        aria-label="Close">
                </button>

            </div>


            <!-- Form -->
            <form action="backend/participant_code.php" method="POST">

                <div class="modal-body">

                    <p>
                        Are you sure you want to delete
                        <strong id="delete_participant_name"></strong>?
                    </p>

                    <p class="text-danger">
                        This action cannot be undone.
                    </p>

                    <!-- ONLY ONE PARTICIPANT ID -->
                    <input type="hidden"
                           name="participants_id"
                           id="delete_participant_id">

                </div>


                <!-- Footer -->
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