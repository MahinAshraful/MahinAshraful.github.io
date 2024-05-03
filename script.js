function addNote(dayElement) {
    const note = prompt("Enter your note for this day:");
    if (note) {
        dayElement.innerHTML += `<div class='note'>${note}</div>`;
    }
}

let works = [];

function addAndSortWorkDetails() {
    event.preventDefault();

    const workDescription = document.getElementById("userInput").value;
    const dueDate = document.getElementById("datePicker").value;

    // Calculate the number of days until the due date
    const currentDate = new Date();
    const targetDate = new Date(dueDate);
    const timeDiff = targetDate - currentDate;
    const daysDiff = Math.ceil(timeDiff / (1000 * 60 * 60 * 24));

    // Add new work detail to the array
    works.push({
        description: workDescription,
        dueDate: dueDate,
        daysRemaining: daysDiff,
        dateString: targetDate.toDateString(), // for display purposes
    });

    // Sort the array by due date
    works.sort((a, b) => new Date(a.dueDate) - new Date(b.dueDate));

    displayWorks();
}

function displayWorks() {
    const detailsContainer = document.getElementById("workDetails");
    detailsContainer.innerHTML = ""; // Clear current list

    // Create and append each work detail in the sorted array
    works.forEach(work => {
        const workEntry = document.createElement("div");
        workEntry.innerHTML = `
            <p>Work Description: ${work.description}</p>
            <p>Due Date: ${work.dateString} (${work.daysRemaining} day(s) remaining)</p>
            <hr>
        `;
        detailsContainer.appendChild(workEntry);
    });
}
