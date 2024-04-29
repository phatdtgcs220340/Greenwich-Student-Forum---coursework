function countWord(inputFieldId, limitDisplay) {
    const inputField = document.getElementById(inputFieldId);
    const limit = document.getElementById(limitDisplay)
    const words = inputField.value.trim().split(' ');
    const wordCount = words.length;
    limit.innerHTML = inputField.value == "" ? "0/20" :wordCount+"/20";
    if (wordCount > 20 || inputField.value.length > 100) {
        // Prevent further typing if word count exceeds the limit
        inputField.value = words.slice(0, 20).join(' ').slice(0, 100);
        }
    else if (wordCount == 20) {
        limit.classList.add("text-red-700");
    }
    else { 
        limit.classList.remove("text-red-700");
    }
}