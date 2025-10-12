<main class="main">

  <!-- Page Title -->
  <div class="page-title light-background">
    <div class="container d-lg-flex justify-content-between align-items-center">
      <h1 class="mb-2 mb-lg-0">Enrollment</h1>
      <nav class="breadcrumbs">
        <ol>
          <li><a href="<?= site_url('dashboard/siswa'); ?>">Home</a></li>
          <li class="current">Enroll</li>
        </ol>
      </nav>
    </div>
  </div><!-- End Page Title -->

  <!-- Enroll Section -->
  <section id="enroll" class="enroll section">

    <div class="container" data-aos="fade-up" data-aos-delay="100">

      <div class="row">
        <div class="col-lg-8 mx-auto">
          <div class="enrollment-form-wrapper">

            <div class="enrollment-header text-center mb-5" data-aos="fade-up" data-aos-delay="200">
              <h2>Enroll in Your Dream Course</h2>
              <p>Take the next step in your educational journey. Complete the form below to secure your spot in our comprehensive online learning program.</p>
            </div>

            <form class="enrollment-form" method="post" action="#">

              <div class="row mb-4">
                <div class="col-md-6">
                  <label for="firstName" class="form-label">First Name *</label>
                  <input type="text" id="firstName" name="firstName" class="form-control" required>
                </div>
                <div class="col-md-6">
                  <label for="lastName" class="form-label">Last Name *</label>
                  <input type="text" id="lastName" name="lastName" class="form-control" required>
                </div>
              </div>

              <div class="row mb-4">
                <div class="col-md-6">
                  <label for="email" class="form-label">Email *</label>
                  <input type="email" id="email" name="email" class="form-control" required>
                </div>
                <div class="col-md-6">
                  <label for="phone" class="form-label">Phone</label>
                  <input type="tel" id="phone" name="phone" class="form-control">
                </div>
              </div>

              <div class="row mb-4">
                <div class="col-12">
                  <label for="course" class="form-label">Select Course *</label>
                  <select id="course" name="course" class="form-select" required>
                    <option value="">Choose a course...</option>
                    <option value="web-development">Full Stack Web Development</option>
                    <option value="data-science">Data Science & Analytics</option>
                    <option value="digital-marketing">Digital Marketing Mastery</option>
                    <option value="ui-ux-design">UI/UX Design Fundamentals</option>
                    <option value="cybersecurity">Cybersecurity Essentials</option>
                    <option value="mobile-development">Mobile App Development</option>
                  </select>
                </div>
              </div>

              <div class="text-center">
                <button type="submit" class="btn btn-enroll">
                  <i class="bi bi-check-circle me-2"></i> Enroll Now
                </button>
              </div>

            </form>

          </div>
        </div>
      </div>

    </div>

  </section><!-- /Enroll Section -->

</main>
