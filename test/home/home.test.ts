import { userNguyenVanA } from "../common/consts";
import login from "../common/login";

fixture("Home")
  .page(`http://127.0.0.1/News_website/?module=home&action=index`)
  .beforeEach(async t => {
    await login(t, userNguyenVanA);
  });

test("Validate header", async t => {

});