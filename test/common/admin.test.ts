import { admin, userNguyenVanA } from "./consts";
import login from "./login";
import { Selector } from "testcafe";
import validateElementExistOrNoExist from "./validateElementExistOrNoExist";

fixture("Home")
  .page(`http://127.0.0.1/News_website/?module=home&action=index`)
  .beforeEach(async t => {
    await login(t, admin);
    await t.click(Selector('.homePage'));
  });

test("Validate header - Admin view", async t => {
  await validateElementExistOrNoExist(t, Selector('.homePage'));
  await validateElementExistOrNoExist(t, Selector('.managePage'));
  await validateElementExistOrNoExist(t, Selector('.adminPage'));
});
