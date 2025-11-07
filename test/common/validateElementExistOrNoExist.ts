export default async function validateElementExistOrNoExist(
  t: TestController,
  selector: Selector,
  isExist: boolean = true,
  timeout: number = 30000,
  description?: string
) {
  const label = description || "";
  if (isExist) {
    await t.expect(selector.exists).ok(`Element not found ${label}`, { timeout });
  } else {
    await t.expect(selector.exists).notOk(`Element should not exist ${label}`, { timeout });
  }
}
