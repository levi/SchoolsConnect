router = new SC.Router();

describe("Application Routes", function() {
  beforeEach(function() {
    this.router   = router;
    this.routeSpy = sinon.spy();
  });

  afterEach(function() {
    window.location.hash = '';
  });

	describe("index route", function() {
    describe("when route is accessed for the first time", function() {
      it("creates a SchoolsList collection", function() {
        
      });

      it("creates a SchoolsList view", function() {
        
      });
    });
  });
});