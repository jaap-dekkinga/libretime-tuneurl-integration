from subprocess import CalledProcessError
from typing import Any, Dict
import logging
from ._ffmpeg import compute_replaygain, probe_replaygain, concateTriggerSound
logger = logging.getLogger(__name__)
from pathlib import Path

def analyze_replaygain(filepath: str, metadata: Dict[str, Any]):
    """
    Extracts the Replaygain loudness normalization factor of a track using ffmpeg.
    """
    try:
        # First probe for existing replaygain metadata.
        track_gain = probe_replaygain(filepath)
        if track_gain is not None:
            metadata["replay_gain"] = track_gain
            return metadata
    except (CalledProcessError, OSError):
        pass

    try:
        track_gain = compute_replaygain(filepath)
        if track_gain is not None:
            metadata["replay_gain"] = track_gain
    except (CalledProcessError, OSError):
        pass

    return metadata

def concate_sound(triggerFilePath: Path, audioFilePath: Path):
    """
    Extracts the Replaygain loudness normalization factor of a track using ffmpeg.
    """
    try:
        # concate two audio files
        logger.info("analyze_replaygain log 111 %s ", triggerFilePath)
        output = concateTriggerSound(triggerFilePath, audioFilePath)
        return output
    except (CalledProcessError, OSError):
        pass