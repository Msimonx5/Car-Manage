(function () {
  const interactiveSelector = 'a[href],button:not(:disabled),input:not(:disabled):not([type="hidden"]):not([type="file"]),select:not(:disabled),textarea:not(:disabled),summary,[role="button"],[role="tab"]';
  let audioContext = null;
  let lastSoundAt = 0;

  function playClickSound() {
    const AudioContextClass = window.AudioContext || window.webkitAudioContext;

    if (!AudioContextClass) return;

    try {
      audioContext ||= new AudioContextClass();
    } catch (error) {
      return;
    }

    function emit() {
      if (audioContext.state !== 'running' || audioContext.currentTime - lastSoundAt < 0.045) return;

      lastSoundAt = audioContext.currentTime;
      const oscillator = audioContext.createOscillator();
      const volume = audioContext.createGain();

      oscillator.type = 'sine';
      oscillator.frequency.value = 740;
      volume.gain.setValueAtTime(0.0001, audioContext.currentTime);
      volume.gain.exponentialRampToValueAtTime(0.035, audioContext.currentTime + 0.003);
      volume.gain.exponentialRampToValueAtTime(0.0001, audioContext.currentTime + 0.045);
      oscillator.connect(volume);
      volume.connect(audioContext.destination);
      oscillator.start();
      oscillator.stop(audioContext.currentTime + 0.05);
    }

    if (audioContext.state !== 'running') {
      audioContext.resume().then(emit).catch(function () {});
      return;
    }

    emit();
  }

  document.addEventListener('click', function (event) {
    if (!event.isTrusted || !(event.target instanceof Element)) return;

    const control = event.target.closest(interactiveSelector);
    if (!control || control.closest('.logout-form,[data-click-sound="off"]')) return;

    playClickSound();
  }, true);
})();