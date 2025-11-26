-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 26, 2025 at 04:27 AM
-- Server version: 8.0.30
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `elkpd`
--

-- --------------------------------------------------------

--
-- Table structure for table `classes`
--

CREATE TABLE `classes` (
  `id` varchar(26) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` varchar(26) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `school_id` varchar(26) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `classes`
--

INSERT INTO `classes` (`id`, `user_id`, `school_id`, `name`, `code`, `created_at`) VALUES
('01K92EK6YBT0FSC80TDYYD3ZN2', '01K91853JEGYFN8Z034389ETB3', '01K8ZB7PXYMHWEQ4K6C5651EB1', 'Kelas 5A', 'Kal-5A', '2025-11-02 21:12:31'),
('01K974TZ7SY1GTZP8H9J5769YA', '01K974STMBGJGP4BEC1C216M48', '01K8ZB7PXYMHWEQ4K6C5651EB1', 'Kelas 3', 'Bah-3', '2025-11-04 16:58:12'),
('0reKlwIkMtYBA798q3xSRduZV6', '01K91853JEGYFN8Z034389ETB3', '01K8ZB7PXYMHWEQ4K6C5651EB1', 'Kelas 4', 'PKN-4', '2025-11-02 11:48:38');

-- --------------------------------------------------------

--
-- Table structure for table `pbl_closing_tts`
--

CREATE TABLE `pbl_closing_tts` (
  `id` char(26) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `class_id` char(26) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `grid_data` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci COMMENT 'Ukuran grid, misal "15" atau data JSON',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pbl_closing_tts`
--

INSERT INTO `pbl_closing_tts` (`id`, `class_id`, `title`, `grid_data`, `created_at`) VALUES
('01KAKB25N6QZCJ5H1X1Z06BR2N', '01K92EK6YBT0FSC80TDYYD3ZN2', 'test', '10', '2025-11-21 20:53:34');

-- --------------------------------------------------------

--
-- Table structure for table `pbl_discussion_topics`
--

CREATE TABLE `pbl_discussion_topics` (
  `id` char(26) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `class_id` char(26) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pbl_discussion_topics`
--

INSERT INTO `pbl_discussion_topics` (`id`, `class_id`, `title`, `description`, `created_at`) VALUES
('01K9HBR0JAWBTQF8K4443MBXSF', '01K92EK6YBT0FSC80TDYYD3ZN2', 'diskusi ipas', 'pertemuan 1 ipas', '2025-11-08 16:11:19');

-- --------------------------------------------------------

--
-- Table structure for table `pbl_essay_questions`
--

CREATE TABLE `pbl_essay_questions` (
  `id` char(26) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `essay_id` char(26) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'FK ke pbl_solution_essays.id',
  `question_number` int NOT NULL COMMENT 'Nomor urut pertanyaan',
  `question_text` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Teks pertanyaan',
  `weight` int DEFAULT '100' COMMENT 'Bobot nilai pertanyaan',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pbl_essay_questions`
--

INSERT INTO `pbl_essay_questions` (`id`, `essay_id`, `question_number`, `question_text`, `weight`, `created_at`) VALUES
('01KAWH3R6XCS1R8FX4X0TW9T69', '01K9PJEPZM76X6ANHYW6ZWHBZH', 1, 'apa yang dimaksud?', 20, '2025-11-25 10:32:27'),
('01KAWJQ56QP8YTBH8V7CPBVSZY', '01K9PJEPZM76X6ANHYW6ZWHBZH', 2, 'jelaskan bagaimana proses?', 20, '2025-11-25 11:00:32');

-- --------------------------------------------------------

--
-- Table structure for table `pbl_essay_submissions`
--

CREATE TABLE `pbl_essay_submissions` (
  `id` char(26) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `essay_id` char(26) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'FK ke pbl_solution_essays.id',
  `user_id` char(26) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'FK ke users.id (siswa)',
  `submission_content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `grade` int DEFAULT NULL,
  `feedback` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pbl_essay_submissions`
--

INSERT INTO `pbl_essay_submissions` (`id`, `essay_id`, `user_id`, `submission_content`, `grade`, `feedback`, `created_at`, `updated_at`) VALUES
('01KAWJS8NS0DKQY0AYJ2CQN28A', '01K9PJEPZM76X6ANHYW6ZWHBZH', '01K912FR1QZHEWJ6MCVK8WEK5V', 'adalah hjksu yukskl yuiklhnmui , jadi stghs ucjyhg wlskd', 80, 'lumayan bagus, semoga dapat ditingkatkan lagi', '2025-11-25 11:01:41', '2025-11-25 11:04:14');

-- --------------------------------------------------------

--
-- Table structure for table `pbl_evaluation_quizzes`
--

CREATE TABLE `pbl_evaluation_quizzes` (
  `id` char(26) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `class_id` char(26) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pbl_evaluation_quizzes`
--

INSERT INTO `pbl_evaluation_quizzes` (`id`, `class_id`, `title`, `description`, `created_at`) VALUES
('01K9PMK0DSQWKKBA1J5KZRZ1G4', '01K92EK6YBT0FSC80TDYYD3ZN2', 'kuis', 'kuis_evaluasi', '2025-11-10 17:22:05');

-- --------------------------------------------------------

--
-- Table structure for table `pbl_evaluation_quiz_questions`
--

CREATE TABLE `pbl_evaluation_quiz_questions` (
  `id` char(26) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `quiz_id` char(26) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'FK ke pbl_evaluation_quizzes.id',
  `question_text` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `option_a` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `option_b` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `option_c` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `option_d` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `correct_answer` enum('A','B','C','D') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pbl_evaluation_quiz_questions`
--

INSERT INTO `pbl_evaluation_quiz_questions` (`id`, `quiz_id`, `question_text`, `option_a`, `option_b`, `option_c`, `option_d`, `correct_answer`, `created_at`) VALUES
('01K9PMQGVFWMSMHDYN29NBWH7N', '01K9PMK0DSQWKKBA1J5KZRZ1G4', 'apa yang dimaksud', 'a', 'b', 'c', 'd', 'B', '2025-11-10 17:24:33');

-- --------------------------------------------------------

--
-- Table structure for table `pbl_final_reflections`
--

CREATE TABLE `pbl_final_reflections` (
  `id` char(26) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `class_id` char(26) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci COMMENT 'Instruksi/prompt untuk refleksi',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pbl_final_reflections`
--

INSERT INTO `pbl_final_reflections` (`id`, `class_id`, `title`, `description`, `created_at`) VALUES
('01K9RDYC2RBRY0DGEHCNSF782D', '01K92EK6YBT0FSC80TDYYD3ZN2', 'a', 'refleksi akhir', '2025-11-11 10:04:26');

-- --------------------------------------------------------

--
-- Table structure for table `pbl_forum_posts`
--

CREATE TABLE `pbl_forum_posts` (
  `id` char(26) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `topic_id` char(26) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'FK ke pbl_discussion_topics.id',
  `user_id` char(26) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'FK ke users.id',
  `post_content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pbl_forum_posts`
--

INSERT INTO `pbl_forum_posts` (`id`, `topic_id`, `user_id`, `post_content`, `created_at`) VALUES
('01K9HYYMNSC0XPWQDCXDSDPTT2', '01K9HBR0JAWBTQF8K4443MBXSF', '01K91853JEGYFN8Z034389ETB3', 'selamat', '2025-11-08 21:47:00'),
('01K9HYYRMD5PK321ERK3NG28CJ', '01K9HBR0JAWBTQF8K4443MBXSF', '01K91853JEGYFN8Z034389ETB3', 'malam', '2025-11-08 21:47:04'),
('01KAT3PR6B8WZH12HHWP0TDH83', '01K9HBR0JAWBTQF8K4443MBXSF', '01K912FR1QZHEWJ6MCVK8WEK5V', 'selamat siang', '2025-11-24 11:59:41');

-- --------------------------------------------------------

--
-- Table structure for table `pbl_observation_slots`
--

CREATE TABLE `pbl_observation_slots` (
  `id` char(26) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `class_id` char(26) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pbl_observation_slots`
--

INSERT INTO `pbl_observation_slots` (`id`, `class_id`, `title`, `description`, `created_at`) VALUES
('01KAJ4NJ1XTEZ89738D7997ZE0', '01K92EK6YBT0FSC80TDYYD3ZN2', 'ruang', 'ruang', '2025-11-21 09:42:35');

-- --------------------------------------------------------

--
-- Table structure for table `pbl_observation_uploads`
--

CREATE TABLE `pbl_observation_uploads` (
  `id` char(26) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `observation_slot_id` char(26) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` char(26) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'ID Siswa',
  `file_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `original_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pbl_orientasi`
--

CREATE TABLE `pbl_orientasi` (
  `id` char(26) NOT NULL,
  `class_id` char(26) NOT NULL,
  `title` varchar(255) NOT NULL,
  `reflection` text,
  `file_path` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `pbl_orientasi`
--

INSERT INTO `pbl_orientasi` (`id`, `class_id`, `title`, `reflection`, `file_path`, `created_at`) VALUES
('01K9Q10WVWF2E9M3PCSDJDHW3S', '01K92EK6YBT0FSC80TDYYD3ZN2', 'test', 'test_refleksi', '', '2025-11-10 20:59:23');

-- --------------------------------------------------------

--
-- Table structure for table `pbl_quizzes`
--

CREATE TABLE `pbl_quizzes` (
  `id` char(26) COLLATE utf8mb4_unicode_ci NOT NULL,
  `class_id` char(26) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pbl_quizzes`
--

INSERT INTO `pbl_quizzes` (`id`, `class_id`, `title`, `description`, `created_at`) VALUES
('01K9RB3FNYYXBC5SBAT705K85N', '01K92EK6YBT0FSC80TDYYD3ZN2', 'kuis', 'kuis ipas', '2025-11-11 09:14:48');

-- --------------------------------------------------------

--
-- Table structure for table `pbl_quiz_questions`
--

CREATE TABLE `pbl_quiz_questions` (
  `id` char(26) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `quiz_id` char(26) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `question_text` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `option_a` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `option_b` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `option_c` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `option_d` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `correct_answer` enum('A','B','C','D') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pbl_quiz_questions`
--

INSERT INTO `pbl_quiz_questions` (`id`, `quiz_id`, `question_text`, `option_a`, `option_b`, `option_c`, `option_d`, `correct_answer`, `created_at`) VALUES
('01K9RB47XCXWVSSEBMT8NRTNC6', '01K9RB3FNYYXBC5SBAT705K85N', 'siapa', 'Saya', 'Aku', 'Dia', 'Kamu', 'C', '2025-11-11 09:15:13'),
('01K9RB47XCZ8MQ9BQQXK134F59', '01K9RB3FNYYXBC5SBAT705K85N', '1+1=', '1', '0', '2', '3', 'C', '2025-11-11 09:15:13');

-- --------------------------------------------------------

--
-- Table structure for table `pbl_quiz_results`
--

CREATE TABLE `pbl_quiz_results` (
  `id` char(26) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `quiz_id` char(26) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` char(26) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `score` int NOT NULL,
  `total_correct` int NOT NULL,
  `total_questions` int NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pbl_reflection_prompts`
--

CREATE TABLE `pbl_reflection_prompts` (
  `id` char(26) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `reflection_id` char(26) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'FK ke pbl_final_reflections.id',
  `prompt_text` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Teks pertanyaan/prompt refleksi',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pbl_reflection_prompts`
--

INSERT INTO `pbl_reflection_prompts` (`id`, `reflection_id`, `prompt_text`, `created_at`) VALUES
('01K9RGRNAHHACVPEB8C1KCFY0G', '01K9RDYC2RBRY0DGEHCNSF782D', 'menurut anda, bagaimana cara memajukkan sekolah', '2025-11-11 10:53:45'),
('01K9RGV8JE9B4MKWWQRG62P5M7', '01K9RDYC2RBRY0DGEHCNSF782D', 'menurut anda, bagaimana proses fotosintesis', '2025-11-11 10:55:10');

-- --------------------------------------------------------

--
-- Table structure for table `pbl_reflection_submissions`
--

CREATE TABLE `pbl_reflection_submissions` (
  `id` char(26) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `reflection_id` char(26) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'FK ke pbl_final_reflections.id',
  `user_id` char(26) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `submission_content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Jawaban refleksi (bisa JSON jika multi-prompt, atau TEXT panjang)',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pbl_reflection_submissions`
--

INSERT INTO `pbl_reflection_submissions` (`id`, `reflection_id`, `user_id`, `submission_content`, `created_at`, `updated_at`) VALUES
('01KAX5YWM2ZRWK3727F3GAAJ77', '01K9RDYC2RBRY0DGEHCNSF782D', '01K912FR1QZHEWJ6MCVK8WEK5V', '{\"01K9RGRNAHHACVPEB8C1KCFY0G\":\"dengan cara \",\"01K9RGV8JE9B4MKWWQRG62P5M7\":\"melalui tumbuhan\"}', '2025-11-25 16:36:48', '2025-11-25 16:36:48');

-- --------------------------------------------------------

--
-- Table structure for table `pbl_solution_essays`
--

CREATE TABLE `pbl_solution_essays` (
  `id` char(26) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `class_id` char(26) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci COMMENT 'Instruksi/prompt untuk esai',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pbl_solution_essays`
--

INSERT INTO `pbl_solution_essays` (`id`, `class_id`, `title`, `description`, `created_at`) VALUES
('01K9PJEPZM76X6ANHYW6ZWHBZH', '01K92EK6YBT0FSC80TDYYD3ZN2', 'esai ipas', 'deskripsi', '2025-11-10 16:44:47');

-- --------------------------------------------------------

--
-- Table structure for table `pbl_tts`
--

CREATE TABLE `pbl_tts` (
  `id` char(26) COLLATE utf8mb4_unicode_ci NOT NULL,
  `class_id` char(26) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `grid_data` text COLLATE utf8mb4_unicode_ci,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pbl_tts`
--

INSERT INTO `pbl_tts` (`id`, `class_id`, `title`, `grid_data`, `created_at`) VALUES
('01K9BNTQP0WNJEWQ6H48J1KNJR', '01K92EK6YBT0FSC80TDYYD3ZN2', 'teka5', '5', '2025-11-06 11:12:08');

-- --------------------------------------------------------

--
-- Table structure for table `pbl_tts_questions`
--

CREATE TABLE `pbl_tts_questions` (
  `id` char(26) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tts_id` char(26) COLLATE utf8mb4_unicode_ci NOT NULL,
  `number` int NOT NULL,
  `direction` enum('across','down') COLLATE utf8mb4_unicode_ci NOT NULL,
  `question` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `answer` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `start_x` int DEFAULT '1',
  `start_y` int DEFAULT '1',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pbl_tts_questions`
--

INSERT INTO `pbl_tts_questions` (`id`, `tts_id`, `number`, `direction`, `question`, `answer`, `start_x`, `start_y`, `created_at`) VALUES
('01KAR25DRCMG96KXHYZ8G4QK6X', '01K9BNTQP0WNJEWQ6H48J1KNJR', 1, 'across', 'Haus', 'MINUM', 1, 1, '2025-11-23 16:54:16'),
('01KATJT02QY755SYVEF7ENAC7J', '01K9BNTQP0WNJEWQ6H48J1KNJR', 1, 'down', 'bintang', 'MALAM', 1, 1, '2025-11-24 16:23:36');

-- --------------------------------------------------------

--
-- Table structure for table `pbl_tts_results`
--

CREATE TABLE `pbl_tts_results` (
  `id` char(26) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tts_id` char(26) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` char(26) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `score` int NOT NULL,
  `total_correct` int NOT NULL,
  `total_questions` int NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` varchar(26) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `role`) VALUES
('01K8WA6A9HTVM98RYM1P5ZWNYH', 'Admin'),
('01K8WA6WVXEKX7JK822G9PVZG9', 'Guru'),
('01K8WA74MMB7VBRM1Y05NS7GNQ', 'Siswa'),
('01K8WA7CX41SY2BEDRT2QBXQ7Q', 'Tamu');

-- --------------------------------------------------------

--
-- Table structure for table `schools`
--

CREATE TABLE `schools` (
  `id` varchar(26) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` text COLLATE utf8mb4_unicode_ci,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `schools`
--

INSERT INTO `schools` (`id`, `name`, `address`, `created_at`) VALUES
('01K8ZAAFMB5A11GW0PCX2W793X', 'SD 01 Bahagia', 'test', '2025-11-01 16:00:08'),
('01K8ZB7PXYMHWEQ4K6C5651EB1', 'SD 01 Kaliabang', 'Kaliabang', '2025-11-01 16:16:05'),
('01K8ZBQ39A778289E67FJD2XY3', 'SD 01', 'tes', '2025-11-01 16:24:30');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` varchar(26) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` varchar(26) COLLATE utf8mb4_unicode_ci NOT NULL,
  `class_id` varchar(26) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `user_id`, `class_id`, `created_at`) VALUES
('01K9A3CMSD46G85CSDZPSMQCX6', '01K912FR1QZHEWJ6MCVK8WEK5V', '01K92EK6YBT0FSC80TDYYD3ZN2', '2025-11-05 20:30:37'),
('01KA3AJMXBWYDCS60QFP26Y9CX', '01K94KA9TRKC5ZEAPM3PRKVP9S', '01K92EK6YBT0FSC80TDYYD3ZN2', '2025-11-15 15:37:15');

-- --------------------------------------------------------

--
-- Table structure for table `teachers`
--

CREATE TABLE `teachers` (
  `id` varchar(26) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` varchar(26) COLLATE utf8mb4_unicode_ci NOT NULL,
  `school_id` varchar(26) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `teachers`
--

INSERT INTO `teachers` (`id`, `user_id`, `school_id`, `created_at`) VALUES
('01K91853QK4JH6WM8C5618YK6Z', '01K91853JEGYFN8Z034389ETB3', '01K8ZB7PXYMHWEQ4K6C5651EB1', '2025-11-02 10:00:43'),
('01K974STT5E77FJFV23HJY0Q80', '01K974STMBGJGP4BEC1C216M48', '01K8ZB7PXYMHWEQ4K6C5651EB1', '2025-11-04 16:57:35');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` varchar(26) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role_id` varchar(26) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '01K8WA74MMB7VBRM1Y05NS7GNQ',
  `name` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'foto.jpg',
  `is_active` tinyint(1) DEFAULT '1',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role_id`, `name`, `email`, `image`, `is_active`, `created_at`) VALUES
('01K8WAF2VCSHCNQYZQNDQ0K806', 'test', '$2y$10$ZBicPw.RXfH2mZVnD.IHruqGGg9S8pVR/cQWGOnujiryKogfnqakq', '01K8WA6A9HTVM98RYM1P5ZWNYH', 'adm', 'test@example.com', 'foto.jpg', 1, '2025-10-31 12:04:55'),
('01K8WTRAA9YN933F4BJ2NXXNKQ', 'guru', '$2y$10$H3S1k38s5/ItrsR.6fOKI.4z74dJtcmHe/AUts9cee6T6rXYkpWJy', '01K8WA6WVXEKX7JK822G9PVZG9', 'guru_ipas', 'guru_ipas@example.com', 'foto.jpg', 1, '2025-10-31 16:49:35'),
('01K912FR1QZHEWJ6MCVK8WEK5V', 'murid', '$2y$10$Sl7f2LZh5aRqpR1HwsGlwumimlhdRlWVrXBBCu6QlRbz8OA7APJbK', '01K8WA74MMB7VBRM1Y05NS7GNQ', 'murid', 'murid@mu.rid', 'foto.jpg', 1, '2025-11-02 08:21:41'),
('01K91853JEGYFN8Z034389ETB3', 'guru_pkn', '$2y$10$BSu7zVS5g04VE8lL2rE1v.HoMMPktC87r6l/v9uAS6Bq29SSM44Uq', '01K8WA6WVXEKX7JK822G9PVZG9', 'guru PKN', 'guru@guru2.id', 'foto.jpg', 1, '2025-11-02 10:00:43'),
('01K94KA9TRKC5ZEAPM3PRKVP9S', 'murid_2', '$2y$10$U/opFpM538ZKLQf2OSF.3evyqEERt/bA4bsxaDsWL4nFqQi1SlRIe', '01K8WA74MMB7VBRM1Y05NS7GNQ', 'murid2', 'murid@mu.rid2', 'foto.jpg', 1, '2025-11-03 17:13:31'),
('01K974STMBGJGP4BEC1C216M48', 'guru_ipas', '$2y$10$f0IWScMr4dFKCCb3GI1ji.30AITxeDIFA.3iuz2cKK8z38R7DBCA2', '01K8WA6WVXEKX7JK822G9PVZG9', 'guru Ipas', 'guru@guru3.id', 'foto.jpg', 1, '2025-11-04 16:57:35'),
('01K976AHZGDA70DMQ7M9MF6SHS', 'murid_3', '$2y$10$QpYl4IuqPUX1JXXgnhoN4OBg.nPy5Ra/9rPmEvtURp7UtkRcXqh/G', '01K8WA74MMB7VBRM1Y05NS7GNQ', 'murid3', 'murid@mu.rid3', 'foto.jpg', 1, '2025-11-04 17:24:11');

-- --------------------------------------------------------

--
-- Table structure for table `user_access_menu`
--

CREATE TABLE `user_access_menu` (
  `id` int NOT NULL,
  `role_id` varchar(26) COLLATE utf8mb4_unicode_ci NOT NULL,
  `menu_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_access_menu`
--

INSERT INTO `user_access_menu` (`id`, `role_id`, `menu_id`) VALUES
(1, '01K8WA6A9HTVM98RYM1P5ZWNYH', 1),
(2, '01K8WA6A9HTVM98RYM1P5ZWNYH', 2),
(3, '01K8WA6A9HTVM98RYM1P5ZWNYH', 3),
(4, '01K8WA6A9HTVM98RYM1P5ZWNYH', 4),
(5, '01K8WA6WVXEKX7JK822G9PVZG9', 2),
(6, '01K8WA74MMB7VBRM1Y05NS7GNQ', 3);

-- --------------------------------------------------------

--
-- Table structure for table `user_menu`
--

CREATE TABLE `user_menu` (
  `id` int NOT NULL,
  `menu` varchar(32) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_menu`
--

INSERT INTO `user_menu` (`id`, `menu`) VALUES
(1, 'Admin'),
(2, 'Guru'),
(3, 'Siswa'),
(4, 'Menu');

-- --------------------------------------------------------

--
-- Table structure for table `user_sub_menu`
--

CREATE TABLE `user_sub_menu` (
  `id` int NOT NULL,
  `menu_id` int NOT NULL,
  `title` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `url` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `icon` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_sub_menu`
--

INSERT INTO `user_sub_menu` (`id`, `menu_id`, `title`, `url`, `icon`, `is_active`) VALUES
(1, 1, 'Dashboard Admin', 'admin/dashboard', 'bi-grid', 1),
(2, 1, 'Kelola Sekolah', 'admin/dashboard/schools', 'bi-building', 1),
(3, 1, 'Kelola Guru', 'admin/dashboard/teachers', 'bi-person', 1),
(4, 1, 'Kelola Murid', 'admin/dashboard/students', 'bi-people', 1),
(5, 4, 'Kelola Menu', 'menu', 'bi-folder', 1),
(6, 4, 'Kelola Submenu', 'menu/submenu', 'bi-folder2-open', 1),
(10, 2, 'Dashboard Guru', 'guru/dashboard', 'bi-grid', 1),
(11, 3, 'Dashboard Siswa', 'siswa/dashboard', 'bi-grid', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `classes`
--
ALTER TABLE `classes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `pbl_closing_tts`
--
ALTER TABLE `pbl_closing_tts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `class_id` (`class_id`);

--
-- Indexes for table `pbl_discussion_topics`
--
ALTER TABLE `pbl_discussion_topics`
  ADD PRIMARY KEY (`id`),
  ADD KEY `class_id` (`class_id`);

--
-- Indexes for table `pbl_essay_questions`
--
ALTER TABLE `pbl_essay_questions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_question_essay` (`essay_id`);

--
-- Indexes for table `pbl_essay_submissions`
--
ALTER TABLE `pbl_essay_submissions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `essay_id` (`essay_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `pbl_evaluation_quizzes`
--
ALTER TABLE `pbl_evaluation_quizzes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `class_id` (`class_id`);

--
-- Indexes for table `pbl_evaluation_quiz_questions`
--
ALTER TABLE `pbl_evaluation_quiz_questions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `quiz_id` (`quiz_id`);

--
-- Indexes for table `pbl_final_reflections`
--
ALTER TABLE `pbl_final_reflections`
  ADD PRIMARY KEY (`id`),
  ADD KEY `class_id` (`class_id`);

--
-- Indexes for table `pbl_forum_posts`
--
ALTER TABLE `pbl_forum_posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `topic_id` (`topic_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `pbl_observation_slots`
--
ALTER TABLE `pbl_observation_slots`
  ADD PRIMARY KEY (`id`),
  ADD KEY `class_id` (`class_id`);

--
-- Indexes for table `pbl_observation_uploads`
--
ALTER TABLE `pbl_observation_uploads`
  ADD PRIMARY KEY (`id`),
  ADD KEY `observation_slot_id` (`observation_slot_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `pbl_orientasi`
--
ALTER TABLE `pbl_orientasi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pbl_quizzes`
--
ALTER TABLE `pbl_quizzes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pbl_quiz_questions`
--
ALTER TABLE `pbl_quiz_questions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `quiz_id` (`quiz_id`);

--
-- Indexes for table `pbl_quiz_results`
--
ALTER TABLE `pbl_quiz_results`
  ADD PRIMARY KEY (`id`),
  ADD KEY `quiz_id` (`quiz_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `pbl_reflection_prompts`
--
ALTER TABLE `pbl_reflection_prompts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reflection_id` (`reflection_id`);

--
-- Indexes for table `pbl_reflection_submissions`
--
ALTER TABLE `pbl_reflection_submissions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reflection_id` (`reflection_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `pbl_solution_essays`
--
ALTER TABLE `pbl_solution_essays`
  ADD PRIMARY KEY (`id`),
  ADD KEY `class_id` (`class_id`);

--
-- Indexes for table `pbl_tts`
--
ALTER TABLE `pbl_tts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pbl_tts_questions`
--
ALTER TABLE `pbl_tts_questions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pbl_tts_results`
--
ALTER TABLE `pbl_tts_results`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tts_id` (`tts_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `schools`
--
ALTER TABLE `schools`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `class_id` (`class_id`);

--
-- Indexes for table `teachers`
--
ALTER TABLE `teachers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `school_id` (`school_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `role_id` (`role_id`);

--
-- Indexes for table `user_access_menu`
--
ALTER TABLE `user_access_menu`
  ADD PRIMARY KEY (`id`),
  ADD KEY `role_id` (`role_id`),
  ADD KEY `menu_id` (`menu_id`);

--
-- Indexes for table `user_menu`
--
ALTER TABLE `user_menu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_sub_menu`
--
ALTER TABLE `user_sub_menu`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `user_access_menu`
--
ALTER TABLE `user_access_menu`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `user_menu`
--
ALTER TABLE `user_menu`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `user_sub_menu`
--
ALTER TABLE `user_sub_menu`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `classes`
--
ALTER TABLE `classes`
  ADD CONSTRAINT `classes_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `pbl_essay_questions`
--
ALTER TABLE `pbl_essay_questions`
  ADD CONSTRAINT `fk_question_essay` FOREIGN KEY (`essay_id`) REFERENCES `pbl_solution_essays` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `pbl_essay_submissions`
--
ALTER TABLE `pbl_essay_submissions`
  ADD CONSTRAINT `pbl_essay_submissions_ibfk_1` FOREIGN KEY (`essay_id`) REFERENCES `pbl_solution_essays` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `pbl_evaluation_quiz_questions`
--
ALTER TABLE `pbl_evaluation_quiz_questions`
  ADD CONSTRAINT `pbl_eval_quiz_questions_ibfk_1` FOREIGN KEY (`quiz_id`) REFERENCES `pbl_evaluation_quizzes` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `pbl_forum_posts`
--
ALTER TABLE `pbl_forum_posts`
  ADD CONSTRAINT `pbl_forum_posts_ibfk_1` FOREIGN KEY (`topic_id`) REFERENCES `pbl_discussion_topics` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `pbl_forum_posts_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `pbl_observation_uploads`
--
ALTER TABLE `pbl_observation_uploads`
  ADD CONSTRAINT `fk_obs_slot` FOREIGN KEY (`observation_slot_id`) REFERENCES `pbl_observation_slots` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `pbl_quiz_questions`
--
ALTER TABLE `pbl_quiz_questions`
  ADD CONSTRAINT `pbl_quiz_questions_ibfk_1` FOREIGN KEY (`quiz_id`) REFERENCES `pbl_quizzes` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `pbl_reflection_prompts`
--
ALTER TABLE `pbl_reflection_prompts`
  ADD CONSTRAINT `pbl_reflection_prompts_ibfk_1` FOREIGN KEY (`reflection_id`) REFERENCES `pbl_final_reflections` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `pbl_reflection_submissions`
--
ALTER TABLE `pbl_reflection_submissions`
  ADD CONSTRAINT `pbl_refl_sub_ibfk_1` FOREIGN KEY (`reflection_id`) REFERENCES `pbl_final_reflections` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `students`
--
ALTER TABLE `students`
  ADD CONSTRAINT `students_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `students_ibfk_2` FOREIGN KEY (`class_id`) REFERENCES `classes` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `teachers`
--
ALTER TABLE `teachers`
  ADD CONSTRAINT `teachers_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `teachers_ibfk_2` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE RESTRICT;

--
-- Constraints for table `user_access_menu`
--
ALTER TABLE `user_access_menu`
  ADD CONSTRAINT `user_access_menu_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_access_menu_ibfk_2` FOREIGN KEY (`menu_id`) REFERENCES `user_menu` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
