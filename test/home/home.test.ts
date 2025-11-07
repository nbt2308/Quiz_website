import { userNguyenVanA } from "../common/consts";
import login from "../common/login";
import { Selector } from "testcafe";

fixture("Home")
  .page(`http://127.0.0.1/News_website/?module=home&action=index`)
  .beforeEach(async t => {
    await login(t, userNguyenVanA);
    await t.click(Selector('.homePage'));
  });
