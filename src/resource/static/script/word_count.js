function countWord(inputFieldId, limitDisplay) {
    const inputField = document.getElementById(inputFieldId);
    const limit = document.getElementById(limitDisplay)
    const words = inputField.value.trim().split(' ');
    const wordCount = words.length;
    limit.innerHTML = inputField.value == "" ? "0/10" :wordCount+"/10";
    if (wordCount > 10 || inputField.value.length > 50) {
        // Prevent further typing if word count exceeds the limit
        inputField.value = words.slice(0, 10).join(' ').slice(0, 50);
        }
    else if (wordCount == 10) {
        limit.classList.add("text-red-700");
    }
    else { 
        limit.classList.remove("text-red-700");
    }
}